document.addEventListener('DOMContentLoaded', function () {
  const BASE_URL = 'http://api.cc.localhost';
  const categoriesSection = document.getElementById('categories');
  const coursesSection = document.getElementById('courses');

 
  /**
   * Truncates a given text to a specified maximum length. If the text exceeds
   * the maximum length, it is truncated and an ellipsis is appended to the end.
   * @param {string} text - The text to truncate.
   * @param {number} maxLength - The maximum length of the text.
   * @returns {string} The truncated text.
   */
  function truncateText(text, maxLength) {
    return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
  }

  /**
   * Updates the text of the header element.
   * @param {string} text - The new text for the header element.
   */
  function updateHeader(text) {
    document.getElementById('header').textContent = text;
  }

  /**
   * Fetches all categories from the API and renders them in the categories
   * section of the page. After the categories are rendered, it fetches all
   * courses and renders them in the courses section of the page.
   */
  function fetchCategories() {
    fetch(`${BASE_URL}/categories`)
      .then(response => response.json())
      .then(categories => {
        const categoryTree = buildCategoryTree(categories);
        renderCategories(categoryTree);
        fetchAllCourses();
      })
      .catch(error => console.error('Error fetching categories:', error));
  }

  /**
   * Builds a tree data structure from a list of categories. The categories
   * that do not have a parent are considered to be the roots of the tree.
   * @param {array} categories - A list of categories.
   * @returns {array} The roots of the category tree.
   */
  function buildCategoryTree(categories) {
    const categoryMap = {};
    categories.forEach(category => {
      category.children = [];
      categoryMap[category.id] = category;
    });
    const tree = [];
    categories.forEach(category => {
      if (category.parent_id) {
        if (categoryMap[category.parent_id]) {
          categoryMap[category.parent_id].children.push(category);
        }
      } else {
        tree.push(category);
      }
    });
    return tree;
  }

  /**
   * Renders a list of categories in the categories section of the page.
   * @param {array} categories - The categories to render. Each category is an
   * object with an `id`, `name`, and `children` property.
   */
  function renderCategories(categories) {
    categoriesSection.innerHTML = createCategoryList(categories);
    categoriesSection.addEventListener('click', handleCategoryClick);
  }

  /**
   * Recursively creates an HTML list of categories.
   * @param {array} categories - The categories to render. Each category is an
   * object with an `id`, `name`, `children`, and `count_of_courses` property.
   * @returns {string} The HTML string of the category list.
   */
  function createCategoryList(categories) {
    return `<ul class="category-list">
      ${categories.map(category => `
        <li>
          <a href="#" class="category-link" data-category-id="${category.id}">${category.name} (${category.count_of_courses})</a>
          ${createCategoryList(category.children)}
        </li>
      `).join('')}
    </ul>`;
  }

  /**
   * Handles a click on a category link in the category list.
   * Resets and sets the active class for the category list, updates the header
   * with the category name, and fetches and renders the courses for the
   * selected category.
   * @param {Event} event - The event object from the category link click.
   * @returns {void}
   */
  function handleCategoryClick(event) {
    event.preventDefault();
    const link = event.target.closest('.category-link');
    if (!link) return;

    // Reset and set active class
    document.querySelectorAll('.category-link').forEach(item => item.classList.remove('active-category'));
    link.classList.add('active-category');

    const categoryId = link.getAttribute('data-category-id');
    const categoryName = link.textContent.split(' (')[0];
    updateHeader(categoryName);

    fetchCoursesByCategory(categoryId);
  }

  /**
   * Fetches all courses from the API and renders them in the courses section of
   * the page. Updates the header with the title 'Course Catalog'.
   * @returns {void}
   */
  function fetchAllCourses() {
    updateHeader('Course Catalog');
    fetch(`${BASE_URL}/courses`)
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching all courses:', error));
  }

  /**
   * Fetches all courses from the API for the given category ID and renders them
   * in the courses section of the page.
   * @param {string} categoryId - The ID of the category to fetch courses for.
   * @returns {void}
   */
  function fetchCoursesByCategory(categoryId) {
    fetch(`${BASE_URL}/courses_by_category/${categoryId}`)
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching courses by category:', error));
  }

  /**
   * Renders the given courses into the courses section of the page.
   * @param {Course[]} courses - The courses to render.
   * @returns {void}
   */
  function renderCourses(courses) {
    const html = `<div class="nested-container">
      ${courses.map(course => `
        <a href="#" class="course-link" data-course-id="${course.id}">
          <section class="course-card">
            <div class="course-image">
              <img class="responsive-image" src="${course.preview ?? 'https://via.placeholder.com/300x180'}" alt="Course Image ${course.name}">
              <div class="course-category">${course.main_category_name ?? 'No category available'}</div>
            </div>
            <div class="course-content">
              <h3 class="course-name">${truncateText(course.name ?? 'No name available', 25)}</h3>
              <p class="course-description">${truncateText(course.description ?? 'No description available', 150)}</p>
            </div>
          </section>
        </a>`
    ).join('')}
    </div>`;
    coursesSection.innerHTML = html;
    coursesSection.addEventListener('click', handleCourseClick);
  }

  /**
   * Handles a click on a course link in the courses section.
   * Fetches the course details and renders the course details section.
   * @param {Event} event - The event object from the course link click.
   * @returns {void}
   */
  function handleCourseClick(event) {
    event.preventDefault();
    const link = event.target.closest('.course-link');
    if (!link) return;

    const courseId = link.getAttribute('data-course-id');
    fetchCourseDetails(courseId);
  }

  /**
   * Fetches the course details from the API and renders the course details section.
   * @param {string} courseId - The ID of the course to fetch.
   * @returns {void}
   */
  function fetchCourseDetails(courseId) {
    fetch(`${BASE_URL}/courses/${courseId}`)
      .then(response => response.json())
      .then(course => renderCourseDetails(course))
      .catch(error => console.error('Error fetching course details:', error));
  }

  /**
   * Renders the course details section of the page with the given course details.
   * Also renders a "Back to Courses" button that fetches all courses and resets
   * the active category link state when clicked.
   * @param {Course} course - The course to render.
   * @returns {void}
   */
  function renderCourseDetails(course) {
    const html = `<h2>${course.name ?? 'No name available'}</h2>
      <img class="responsive-image" src="${course.preview ?? 'https://via.placeholder.com/300x180'}" alt="Course Image ${course.name}">
      <p>${course.description ?? 'No description available'}</p>
      <button id="back-to-courses">Back to Courses</button>`;
    coursesSection.innerHTML = html;
    const backButton = document.getElementById('back-to-courses');
    backButton.addEventListener('click', function () {
      // Fetch all courses and reset active category link state
      fetchAllCourses();
      document.querySelectorAll('.category-link').forEach(item => item.classList.remove('active-category'));
    });
  }

  // Initial load of categories and courses
  fetchCategories();
});
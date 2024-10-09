document.addEventListener('DOMContentLoaded', function () {
  const categoriesSection = document.getElementById('categories');
  const coursesSection = document.getElementById('courses');

  /**
   * Truncates a given text to a specified maximum length. If the text exceeds
   * the maximum length, it will be truncated to the maximum length and an
   * ellipsis will be appended.
   *
   * @param {string} text - The input text to truncate.
   * @param {number} maxLength - The maximum length of the output text.
   * @return {string} The truncated text.
   */
  function truncateText(text, maxLength) {
    if (text.length > maxLength) {
      return text.substring(0, maxLength) + "...";
    }
    return text;
  }

  /**
   * Updates the text of the header element at the top of the page with the given
   * text.
   *
   * @param {string} text - The text to set as the content of the header element.
   */
  function updateHeader(text) {
    const headerElement = document.getElementById('header');
    headerElement.textContent = text;
  }

  /**
   * Fetches all categories from the API and renders them in the left section.
   * Also fetches all courses initially and renders them in the right section.
   *
   * @private
   */
  function fetchCategories() {
    fetch('http://api.cc.localhost/categories')
      .then(response => response.json())
      .then(categories => {
        const categoryTree = buildCategoryTree(categories);
        renderCategories(categoryTree);
        fetchAllCourses(); // Initially load all courses in the right section
      })
      .catch(error => console.error('Error fetching categories:', error));
  }

  /**
   * Takes a flat list of categories and builds a nested tree structure from it.
   * The returned tree is an array of category objects, where each category object
   * has a "children" property that is an array of its subcategories.
   *
   * @param {Array} categories - An array of category objects
   * @return {Array} A nested array of category objects
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
   * Render a nested list of categories into the page's categories section, and
   * add event listeners to each category link.
   * @param {Array} categories - An array of category objects
   */
  function renderCategories(categories) {
    const html = `${createCategoryList(categories)}`;
    categoriesSection.innerHTML = html;
    addCategoryEventListeners();
  }

  /**
   * Returns a string of HTML representing a nested list of categories.
   * The categories must have an "id", "name", and "count_of_courses" property.
   * The "children" property is optional, and if present, it is an array of
   * subcategories that will be recursively rendered in the list.
   *
   * @param {Array} categories - An array of category objects
   * @return {string} A string of HTML representing a nested list of categories
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
   * Add event listeners to category links.
   * When a category link is clicked, the link gets highlighted, the header is
   * updated with the selected category name, and the courses by the selected
   * category ID are fetched and rendered.
   */
  function addCategoryEventListeners() {
    document.querySelectorAll('.category-link').forEach(link => {
      link.addEventListener('click', function (event) {
        event.preventDefault();

        // Remove active class from all categories
        document.querySelectorAll('.category-link').forEach(item => {
          item.classList.remove('active-category');
        });

        // Highlight the clicked category
        this.classList.add('active-category');

        // Fetch and render courses by the selected category ID
        const categoryId = this.getAttribute('data-category-id');
        const categoryName = this.textContent.split(' (')[0]; // Assuming name format: "Category Name (10)"

        // Update the header with the selected category name
        updateHeader(categoryName);

        fetchCoursesByCategory(categoryId);
      });
    });
  }

  /**
   * Fetches all courses from the API and renders them in the courses section.
   * Also updates the header with the title "Course Catalog".
   */
  function fetchAllCourses() {
    updateHeader('Course Catalog');
    fetch('http://api.cc.localhost/courses') // Assuming an endpoint to fetch all courses
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching all courses:', error));
  }

  /**
   * Fetches all courses by a given category ID from the API and renders them
   * in the courses section.
   *
   * @param {string} categoryId The ID of the category to fetch courses from.
   */
  function fetchCoursesByCategory(categoryId) {
    fetch(`http://api.cc.localhost/courses_by_category/${categoryId}`)
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching courses by category:', error));
  }

  /**
   * Renders the given courses array in the courses section of the page.
   *
   * @param {array} courses An array of course objects with the following properties:
   *  - id {string}: The ID of the course.
   *  - name {string}: The name of the course.
   *  - description {string}: A brief description of the course.
   *  - preview {string}: A URL pointing to a preview image for the course.
   *  - main_category_name {string}: The name of the main category the course belongs to.
   */
  function renderCourses(courses) {
    const html = `<div class="nested-container">
                    ${courses.map(course => `
                      <a href="#" class="course-link" data-course-id="${course.id}">
                        <section class="course-card">
                            <div class="course-image">
                                <img class="responsive-image" src="${course.preview ?? 'https://via.placeholder.com/300x180'}" alt="Course Image ${course.name ?? 'No name available'}">
                                <div class="course-category">${course.main_category_name ?? 'No category available'}</div>
                            </div>
                            <div class="course-content">
                                <h3 class="course-name">${truncateText(course.name ?? 'No name available', 25)}</h3>
                                <p class="course-description">${truncateText(course.description ?? 'No description available', 150)}</p>
                            </div>
                        </section>
                      </a>`).join('')}
                  </div>`;
    coursesSection.innerHTML = html;
    addCourseEventListeners();
  }

  /**
   * Adds event listeners to the course links. When a course link is clicked,
   * the event is prevented from propagating, and the course details are
   * fetched and rendered.
   */
  function addCourseEventListeners() {
    document.querySelectorAll('.course-link').forEach(link => {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        const courseId = this.getAttribute('data-course-id');
        fetchCourseDetails(courseId);
      });
    });
  }

  /**
   * Fetches the details of a course from the API by its ID and renders them.
   *
   * @param {string} courseId The ID of the course to fetch.
   */
  function fetchCourseDetails(courseId) {
    fetch(`http://api.cc.localhost/courses/${courseId}`)
      .then(response => response.json())
      .then(course => renderCourseDetails(course))
      .catch(error => console.error('Error fetching course details:', error));
  }

  /**
   * Renders the details of a course in the #courses section.
   * 
   * @param {object} course The course object containing its details.
   * 
   * The rendered HTML will contain the course name, image, description, and a
   * "Back to Courses" button. When the button is clicked, the function will
   * fetch all courses again and render them.
   */
  function renderCourseDetails(course) {
    const html = `<h2>${course.name ?? 'No name available'}</h2>
                  <img class="responsive-image" src="${course.preview ?? 'https://via.placeholder.com/300x180'}" alt="Course Image ${course.name ?? 'No name available'}">
                  <p>${course.description ?? 'No description available'}</p>
                  <button id="back-to-courses">Back to Courses</button>`;
    coursesSection.innerHTML = html;
    document.getElementById('back-to-courses').addEventListener('click', function () {
      fetchAllCourses(); // Or fetchCoursesByCategory(course.category_id); if you want to go back to category view
    });
  }

  // Initial load of categories and courses
  fetchCategories();
});
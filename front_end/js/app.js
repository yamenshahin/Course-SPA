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

  // Update header based on the category selected
  function updateHeader(text) {
    const headerElement = document.getElementById('header');
    headerElement.textContent = text;
  }
  // Function to fetch and render categories
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

  // Build a hierarchical category tree from flat data
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

  // Render hierarchical categories
  function renderCategories(categories) {
    const html = `${createCategoryList(categories)}`;
    categoriesSection.innerHTML = html;
    addCategoryEventListeners();
  }

  // Create a nested list of categories
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

  // Add event listeners to category links
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

  // Fetch and render all courses
  function fetchAllCourses() {
    updateHeader('Course Catalog');
    fetch('http://api.cc.localhost/courses') // Assuming an endpoint to fetch all courses
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching all courses:', error));
  }

  // Fetch and render courses by category ID
  function fetchCoursesByCategory(categoryId) {
    fetch(`http://api.cc.localhost/courses_by_category/${categoryId}`)
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching courses by category:', error));
  }

  // Render courses with links to their individual pages
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

  // Add event listeners to course links
  function addCourseEventListeners() {
    document.querySelectorAll('.course-link').forEach(link => {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        const courseId = this.getAttribute('data-course-id');
        fetchCourseDetails(courseId);
      });
    });
  }

  // Fetch and display course details
  function fetchCourseDetails(courseId) {
    fetch(`http://api.cc.localhost/courses/${courseId}`)
      .then(response => response.json())
      .then(course => renderCourseDetails(course))
      .catch(error => console.error('Error fetching course details:', error));
  }

  // Render course details
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
document.addEventListener('DOMContentLoaded', function () {
  const categoriesSection = document.getElementById('categories');
  const coursesSection = document.getElementById('courses');

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
    const html = `<h2>Categories</h2>${createCategoryList(categories)}`;
    categoriesSection.innerHTML = html;
    addCategoryEventListeners();
  }

  // Create a nested list of categories
  function createCategoryList(categories) {
    return `<ul>
      ${categories.map(category => `
        <li>
          <a href="#" class="category-link" data-category-id="${category.id}">${category.name}</a>
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
        const categoryId = this.getAttribute('data-category-id');
        fetchCoursesByCategory(categoryId);
      });
    });
  }

  // Fetch and render all courses
  function fetchAllCourses() {
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
    const html = `<h2>Courses</h2>
                  <ul>
                    ${courses.map(course => `
                      <li>
                        <a href="#" class="course-link" data-course-id="${course.id}">${course.name ?? 'No name available'}</a>
                      </li>`).join('')}
                  </ul>`;
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
    const html = `<h1>${course.name}</h1>
                  <p>${course.description}</p>
                  <button id="back-to-courses">Back to Courses</button>`;
    coursesSection.innerHTML = html;
    document.getElementById('back-to-courses').addEventListener('click', function () {
      fetchAllCourses(); // Or fetchCoursesByCategory(course.category_id); if you want to go back to category view
    });
  }

  // Initial load of categories and courses
  fetchCategories();
});
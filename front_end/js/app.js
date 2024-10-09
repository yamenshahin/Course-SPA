document.addEventListener('DOMContentLoaded', function () {
  const BASE_URL = 'http://api.cc.localhost';
  const categoriesSection = document.getElementById('categories');
  const coursesSection = document.getElementById('courses');

  // Function to truncate text
  function truncateText(text, maxLength) {
    return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
  }

  // Function to update header text
  function updateHeader(text) {
    document.getElementById('header').textContent = text;
  }

  // Fetch categories and render them
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

  // Build a nested category tree
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

  // Render categories in the categories section
  function renderCategories(categories) {
    categoriesSection.innerHTML = createCategoryList(categories);
    categoriesSection.addEventListener('click', handleCategoryClick);
  }

  // Create a list of categories
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

  // Handle category click using event delegation
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

  // Fetch and render all courses
  function fetchAllCourses() {
    updateHeader('Course Catalog');
    fetch(`${BASE_URL}/courses`)
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching all courses:', error));
  }

  // Fetch courses by category
  function fetchCoursesByCategory(categoryId) {
    fetch(`${BASE_URL}/courses_by_category/${categoryId}`)
      .then(response => response.json())
      .then(courses => renderCourses(courses))
      .catch(error => console.error('Error fetching courses by category:', error));
  }

  // Render courses in the courses section
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

  // Handle course click using event delegation
  function handleCourseClick(event) {
    event.preventDefault();
    const link = event.target.closest('.course-link');
    if (!link) return;

    const courseId = link.getAttribute('data-course-id');
    fetchCourseDetails(courseId);
  }

  // Fetch course details
  function fetchCourseDetails(courseId) {
    fetch(`${BASE_URL}/courses/${courseId}`)
      .then(response => response.json())
      .then(course => renderCourseDetails(course))
      .catch(error => console.error('Error fetching course details:', error));
  }

  // Render course details
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
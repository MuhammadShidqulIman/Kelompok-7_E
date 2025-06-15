// Data storage keys
    const STORAGE_USERS_KEY = "portfolio_users";
    const STORAGE_PROJECTS_KEY = "portfolio_projects";
    const STORAGE_SESSION_KEY = "portfolio_session";

    // Elements
    const navLinks = document.getElementById("nav-links");
    const mobileNavLinks = document.getElementById("mobile-nav-links");
    const authButtons = document.getElementById("auth-buttons");
    const btnLogin = document.getElementById("btn-login");
    const btnRegister = document.getElementById("btn-register");
    const btnLogout = document.getElementById("btn-logout");
    const btnLoginMobile = document.getElementById("btn-login-mobile");
    const btnRegisterMobile = document.getElementById("btn-register-mobile");
    const navHome = document.getElementById("nav-home");
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    const modalLogin = document.getElementById("modal-login");
    const modalRegister = document.getElementById("modal-register");
    const modalProject = document.getElementById("modal-project");

    const btnLoginClose = document.getElementById("btn-login-close");
    const btnRegisterClose = document.getElementById("btn-register-close");
    const btnProjectClose = document.getElementById("btn-project-close");
    const switchToRegister = document.getElementById("switch-to-register");
    const switchToLogin = document.getElementById("switch-to-login");

    const formLogin = document.getElementById("form-login");
    const formRegister = document.getElementById("form-register");
    const formProject = document.getElementById("form-project");

    const projectsList = document.getElementById("projects-list");
    const adminAddProjectContainer = document.getElementById("admin-add-project-container");
    const btnAddProject = document.getElementById("btn-add-project");

    // Pages
    const pages = ["home", "about", "projects", "contact"];
    const pageSections = pages.map((p) => document.getElementById(p));

    // Current user and editing project
    let currentUser = null;
    let editingProjectId = null;

    // Initialize default users and projects if not present
    function initializeData() {
      if (!localStorage.getItem(STORAGE_USERS_KEY)) {
        // Default users: admin and a visitor
        const defaultUsers = [
          { username: "admin", password: "admin123", email: "admin@example.com", role: "admin" },
          { username: "visitor", password: "visitor123", email: "visitor@example.com", role: "visitor" },
        ];
        localStorage.setItem(STORAGE_USERS_KEY, JSON.stringify(defaultUsers));
      }
      
      if (!localStorage.getItem(STORAGE_PROJECTS_KEY)) {
        // Default projects with descriptions
        const defaultProjects = [
          {
            id: generateId(),
            title: "GAMELAB Program",
            image: "https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
            description: "An interactive platform for game development education with real-time coding environment."
          },
          {
            id: generateId(),
            title: "Educa Academies",
            image: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
            description: "Online learning management system for universities with advanced analytics."
          }
 ];
        localStorage.setItem(STORAGE_PROJECTS_KEY, JSON.stringify(defaultProjects));
      }
    }

    // Generate unique ID
    function generateId() {
      return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }

    // Check if user is logged in
    function checkSession() {
      const session = JSON.parse(localStorage.getItem(STORAGE_SESSION_KEY));
      if (session && session.username) {
        const users = JSON.parse(localStorage.getItem(STORAGE_USERS_KEY));
        currentUser = users.find(u => u.username === session.username);
        updateAuthUI();
      }
    }

    // Update authentication UI
    function updateAuthUI() {
      if (currentUser) {
        btnLogin.classList.add('hidden');
        btnRegister.classList.add('hidden');
        btnLoginMobile.classList.add('hidden');
        btnRegisterMobile.classList.add('hidden');
        btnLogout.classList.remove('hidden');
        
        // Show admin controls if user is admin
        if (currentUser.role === 'admin') {
          adminAddProjectContainer.style.display = 'block';
        } else {
          adminAddProjectContainer.style.display = 'none';
        }
      } else {
        btnLogin.classList.remove('hidden');
        btnRegister.classList.remove('hidden');
        btnLoginMobile.classList.remove('hidden');
        btnRegisterMobile.classList.remove('hidden');
        btnLogout.classList.add('hidden');
        adminAddProjectContainer.style.display = 'none';
      }
    }

    // Handle login
    function handleLogin(e) {
      e.preventDefault();
      const username = document.getElementById('login-username').value;
      const password = document.getElementById('login-password').value;
      
      const users = JSON.parse(localStorage.getItem(STORAGE_USERS_KEY));
      const user = users.find(u => u.username === username && u.password === password);
      
      if (user) {
        currentUser = user;
        localStorage.setItem(STORAGE_SESSION_KEY, JSON.stringify({ username: user.username }));
        updateAuthUI();
        modalLogin.classList.add('hidden');
        showToast('Login successful!', 'success');
      } else {
        showToast('Invalid username or password', 'error');
      }
    }

    // Handle registration
    function handleRegister(e) {
      e.preventDefault();
      const username = document.getElementById('register-username').value;
      const email = document.getElementById('register-email').value;
      const password = document.getElementById('register-password').value;
      const confirmPassword = document.getElementById('register-password-confirm').value;
      
      if (password !== confirmPassword) {
        showToast('Passwords do not match', 'error');
        return;
      }
      
      const users = JSON.parse(localStorage.getItem(STORAGE_USERS_KEY));
      
      if (users.some(u => u.username === username)) {
        showToast('Username already exists', 'error');
        return;
      }
      
      if (users.some(u => u.email === email)) {
        showToast('Email already registered', 'error');
        return;
      }
      
      const newUser = {
        username,
        email,
        password,
        role: 'visitor' // Default role
      };
      
      users.push(newUser);
      localStorage.setItem(STORAGE_USERS_KEY, JSON.stringify(users));
      
      currentUser = newUser;
      localStorage.setItem(STORAGE_SESSION_KEY, JSON.stringify({ username: newUser.username }));
      updateAuthUI();
      modalRegister.classList.add('hidden');
      showToast('Registration successful!', 'success');
    }

    // Handle logout
    function handleLogout() {
      currentUser = null;
      localStorage.removeItem(STORAGE_SESSION_KEY);
      updateAuthUI();
      showToast('Logged out successfully', 'success');
    }

    // Load projects
    function loadProjects() {
      const projects = JSON.parse(localStorage.getItem(STORAGE_PROJECTS_KEY)) || [];
      projectsList.innerHTML = '';
      
      projects.forEach(project => {
        const projectCard = document.createElement('div');
        projectCard.className = 'project-card bg-white rounded-lg overflow-hidden shadow-md';
        projectCard.innerHTML = `
          <div class="h-48 overflow-hidden">
            <img src="${project.image}" alt="${project.title}" class="w-full h-full object-cover">
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2">${project.title}</h3>
            <p class="text-gray-600 mb-4">${project.description}</p>
            ${currentUser?.role === 'admin' ? `
              <div class="flex space-x-2">
                <button class="edit-project-btn bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm" data-id="${project.id}">
                  Edit
                </button>
                <button class="delete-project-btn bg-red-100 text-red-700 px-3 py-1 rounded text-sm" data-id="${project.id}">
                  Delete
                </button>
              </div>
            ` : ''}
          </div>
        `;
        projectsList.appendChild(projectCard);
      });
      
      // Add event listeners for edit/delete buttons
      document.querySelectorAll('.edit-project-btn').forEach(btn => {
        btn.addEventListener('click', () => editProject(btn.dataset.id));
      });
      
      document.querySelectorAll('.delete-project-btn').forEach(btn => {
        btn.addEventListener('click', () => deleteProject(btn.dataset.id));
      });
    }

    // Add new project
    function addProject() {
      editingProjectId = null;
      document.getElementById('modal-project-title').textContent = 'Add New Project';
      document.getElementById('project-title').value = '';
      document.getElementById('project-image').value = '';
      document.getElementById('project-description').value = '';
      modalProject.classList.remove('hidden');
    }

    // Edit project
    function editProject(id) {
      const projects = JSON.parse(localStorage.getItem(STORAGE_PROJECTS_KEY));
      const project = projects.find(p => p.id === id);
      
      if (project) {
        editingProjectId = id;
        document.getElementById('modal-project-title').textContent = 'Edit Project';
        document.getElementById('project-title').value = project.title;
        document.getElementById('project-image').value = project.image;
        document.getElementById('project-description').value = project.description;
        modalProject.classList.remove('hidden');
      }
    }

    // Delete project
    function deleteProject(id) {
      if (confirm('Are you sure you want to delete this project?')) {
        const projects = JSON.parse(localStorage.getItem(STORAGE_PROJECTS_KEY));
        const updatedProjects = projects.filter(p => p.id !== id);
        localStorage.setItem(STORAGE_PROJECTS_KEY, JSON.stringify(updatedProjects));
        loadProjects();
        showToast('Project deleted', 'success');
      }
    }

    // Save project (add or edit)
    function saveProject(e) {
      e.preventDefault();
      
      const title = document.getElementById('project-title').value;
      const image = document.getElementById('project-image').value;
      const description = document.getElementById('project-description').value;
      
      if (!title || !image || !description) {
        showToast('Please fill all fields', 'error');
        return;
      }
      
      const projects = JSON.parse(localStorage.getItem(STORAGE_PROJECTS_KEY));
      
      if (editingProjectId) {
        // Update existing project
        const projectIndex = projects.findIndex(p => p.id === editingProjectId);
        if (projectIndex !== -1) {
          projects[projectIndex] = { ...projects[projectIndex], title, image, description };
          localStorage.setItem(STORAGE_PROJECTS_KEY, JSON.stringify(projects));
          showToast('Project updated', 'success');
        }
      } else {
        // Add new project
        const newProject = {
          id: generateId(),
          title,
          image,
          description
        };
        projects.push(newProject);
        localStorage.setItem(STORAGE_PROJECTS_KEY, JSON.stringify(projects));
        showToast('Project added', 'success');
      }
      
      modalProject.classList.add('hidden');
      loadProjects();
    }

    // Show toast notification
    function showToast(message, type) {
      const toast = document.createElement('div');
      toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
      }`;
      toast.textContent = message;
      document.body.appendChild(toast);
      
      setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => toast.remove(), 300);
      }, 3000);
    }

    // Switch between pages
    function showPage(page) {
      pageSections.forEach(section => section.classList.add('hidden'));
      document.getElementById(page).classList.remove('hidden');
      
      // Update active nav link
      document.querySelectorAll('.nav-link').forEach(link => {
        if (link.dataset.page === page) {
          link.classList.add('active');
        } else {
          link.classList.remove('active');
        }
      });
      
      // Close mobile menu if open
      mobileMenu.classList.add('hidden');
    }

    // Typing animation for hero section
    function initTypingAnimation() {
      const words = ["Frontend Developer", "UI/UX Designer", "Web Enthusiast"];
      const typingElement = document.querySelector('.typing-animation');
      let wordIndex = 0;
      let charIndex = 0;
      let isDeleting = false;
      let typingSpeed = 150;
      
      function type() {
        const currentWord = words[wordIndex];
        
        if (isDeleting) {
          typingElement.textContent = currentWord.substring(0, charIndex - 1);
          charIndex--;
          typingSpeed = 100;
        } else {
          typingElement.textContent = currentWord.substring(0, charIndex + 1);
          charIndex++;
          typingSpeed = 150;
        }
        
        if (!isDeleting && charIndex === currentWord.length) {
          isDeleting = true;
          typingSpeed = 1500; // Pause at end of word
        } else if (isDeleting && charIndex === 0) {
          isDeleting = false;
          wordIndex = (wordIndex + 1) % words.length;
          typingSpeed = 500; // Pause before typing next word
        }
        
        setTimeout(type, typingSpeed);
      }
      
      type();
    }

    // Initialize the application
    function init() {
      initializeData();
      checkSession();
      loadProjects();
      initTypingAnimation();
      
      // Show home page by default
      showPage('home');
      
      // Event listeners
      navLinks.addEventListener('click', (e) => {
        if (e.target.classList.contains('nav-link')) {
          showPage(e.target.dataset.page);
        }
      });
      
      mobileNavLinks.addEventListener('click', (e) => {
        if (e.target.classList.contains('nav-link')) {
          showPage(e.target.dataset.page);
        }
      });
      
      navHome.addEventListener('click', () => showPage('home'));
      
      btnLogin.addEventListener('click', () => modalLogin.classList.remove('hidden'));
      btnRegister.addEventListener('click', () => modalRegister.classList.remove('hidden'));
      btnLogout.addEventListener('click', handleLogout);
      
      btnLoginMobile.addEventListener('click', () => modalLogin.classList.remove('hidden'));
      btnRegisterMobile.addEventListener('click', () => modalRegister.classList.remove('hidden'));
      
      btnLoginClose.addEventListener('click', () => modalLogin.classList.add('hidden'));
      btnRegisterClose.addEventListener('click', () => modalRegister.classList.add('hidden'));
      btnProjectClose.addEventListener('click', () => modalProject.classList.add('hidden'));
      document.getElementById('btn-project-cancel').addEventListener('click', () => modalProject.classList.add('hidden'));
      
      switchToRegister.addEventListener('click', () => {
        modalLogin.classList.add('hidden');
        modalRegister.classList.remove('hidden');
      });
      
      switchToLogin.addEventListener('click', () => {
        modalRegister.classList.add('hidden');
        modalLogin.classList.remove('hidden');
      });
      
      formLogin.addEventListener('submit', handleLogin);
      formRegister.addEventListener('submit', handleRegister);
      formProject.addEventListener('submit', saveProject);
      
      btnAddProject.addEventListener('click', addProject);
      
      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
      
      // Close modals when clicking outside
      [modalLogin, modalRegister, modalProject].forEach(modal => {
        modal.addEventListener('click', (e) => {
          if (e.target === modal) {
            modal.classList.add('hidden');
          }
        });
      });
    }

    // Start the application
    document.addEventListener('DOMContentLoaded', init);
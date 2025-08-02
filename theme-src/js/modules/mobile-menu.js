/**
 * Mobile Menu Component
 * Handles mobile navigation toggle and accessibility
 */
export class MobileMenu {
  constructor() {
    // Add a delay to ensure DOM is fully loaded
    setTimeout(() => {
      this.menuToggle = document.querySelector('.menu-toggle');
      this.primaryMenu = document.querySelector('#primary-menu');
      this.isOpen = false;
      
      
      if (this.menuToggle && this.primaryMenu) {
        this.init();
      } else {
      }
    }, 100);
  }

  init() {
    
    this.menuToggle.addEventListener('click', (e) => {
      e.preventDefault();
      this.toggle();
    });

    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isOpen) {
        this.close();
      }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (this.isOpen && !this.menuToggle.contains(e.target) && !this.primaryMenu.contains(e.target)) {
        this.close();
      }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768 && this.isOpen) {
        this.close();
      }
    });
  }

  toggle() {
    if (this.isOpen) {
      this.close();
    } else {
      this.open();
    }
  }

  open() {
    this.isOpen = true;
    
    // Remove hidden class and add mobile-open class
    this.primaryMenu.classList.remove('hidden');
    this.primaryMenu.classList.add('mobile-open');
    
    // Update button attributes
    this.menuToggle.setAttribute('aria-expanded', 'true');
    
    // Update icon
    this.updateToggleIcon(true);
    
  }

  close() {
    this.isOpen = false;
    
    // Remove mobile-open class and add hidden class back
    this.primaryMenu.classList.remove('mobile-open');
    this.primaryMenu.classList.add('hidden');
    
    // Update button attributes
    this.menuToggle.setAttribute('aria-expanded', 'false');
    
    // Update icon
    this.updateToggleIcon(false);
    
  }

  updateToggleIcon(isOpen) {
    const icon = this.menuToggle.querySelector('svg');
    if (icon) {
      if (isOpen) {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
      } else {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
      }
    }
  }

  trapFocus() {
    const focusableElements = this.primaryMenu.querySelectorAll('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])');
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    this.primaryMenu.addEventListener('keydown', (e) => {
      if (e.key === 'Tab') {
        if (e.shiftKey) {
          if (document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
          }
        } else {
          if (document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
          }
        }
      }
    });

    // Focus first element
    if (firstElement) {
      firstElement.focus();
    }
  }
}
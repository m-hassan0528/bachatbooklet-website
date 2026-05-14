 <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                  <div class="flex-shrink-0 flex items-center">
                   <img class="booklet-footer-logo" src="{{ asset('images/booklet-logo-2.png') }}" alt="FAQ Banner">
               </div>
                    <p class="text-gray-400 text-sm">
                        Your trusted partner for discovering amazing deals and saving money across your city.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#how-it-works" class="hover:text-white transition">How It Works</a></li>
                       <li>
    <a href="{{ route('category') }}" class="hover:text-white transition">
        Categories
    </a>
</li>
                        <li><a href="#" class="hover:text-white transition">Partner Brands</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('faq') }}" class="hover:text-white transition">FAQs</a></li>
                        <li> <a href="{{ route('contact') }}" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="{{ route('terms-and-services') }}" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Email: info@bachatBooklet.com</li>
                        <li>Phone: +92 333 3211414</li>
                        <li>Address: office # 2/23 , silk center , rehamanabad , muree road , rawalpindi</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} BachatBooklet. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });



        // Form Validation
        const bookOrderForm = document.querySelector('form[action="{{ route('book-order.store') }}"]');

        if (bookOrderForm) {
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            const nameInput = document.getElementById('name');
            const addressInput = document.getElementById('address');
            const cityInput = document.getElementById('city');
            const stateInput = document.getElementById('state');
            const pincodeInput = document.getElementById('pincode');

            // Phone number validation
            phoneInput.addEventListener('input', function(e) {
                // Remove any non-digit characters
                let value = e.target.value.replace(/\D/g, '');

                // Limit to 11 digits
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }

                e.target.value = value;

                // Validate format
                const phoneRegex = /^03[0-9]{9}$/;
                const errorMsg = e.target.parentElement.querySelector('.phone-error');

                if (value.length === 11) {
                    if (phoneRegex.test(value)) {
                        e.target.classList.remove('border-red-500');
                        e.target.classList.add('border-green-500');
                        if (errorMsg) errorMsg.remove();
                    } else {
                        e.target.classList.remove('border-green-500');
                        e.target.classList.add('border-red-500');
                        if (!errorMsg) {
                            const error = document.createElement('p');
                            error.className = 'text-red-500 text-sm mt-1 phone-error';
                            error.textContent = 'Phone number must start with 03';
                            e.target.parentElement.appendChild(error);
                        }
                    }
                } else if (value.length > 0) {
                    e.target.classList.remove('border-green-500', 'border-red-500');
                    if (errorMsg) errorMsg.remove();
                }
            });

            // Email validation
            emailInput.addEventListener('blur', function(e) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const errorMsg = e.target.parentElement.querySelector('.email-error');

                if (e.target.value.length > 0) {
                    if (emailRegex.test(e.target.value)) {
                        e.target.classList.remove('border-red-500');
                        e.target.classList.add('border-green-500');
                        if (errorMsg) errorMsg.remove();
                    } else {
                        e.target.classList.remove('border-green-500');
                        e.target.classList.add('border-red-500');
                        if (!errorMsg) {
                            const error = document.createElement('p');
                            error.className = 'text-red-500 text-sm mt-1 email-error';
                            error.textContent = 'Please enter a valid email address';
                            e.target.parentElement.appendChild(error);
                        }
                    }
                }
            });

            // Pincode validation (allow only digits)
            pincodeInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            // Form submission validation
            bookOrderForm.addEventListener('submit', function(e) {
                let isValid = true;
                const errors = [];

                // Clear previous custom errors
                document.querySelectorAll('.custom-error').forEach(el => el.remove());

                // Validate name
                if (nameInput.value.trim().length < 3) {
                    isValid = false;
                    showError(nameInput, 'Name must be at least 3 characters long');
                    errors.push('Name is invalid');
                }

                // Validate phone
                const phoneRegex = /^03[0-9]{9}$/;
                if (!phoneRegex.test(phoneInput.value)) {
                    isValid = false;
                    showError(phoneInput, 'Phone number must be 11 digits starting with 03');
                    errors.push('Phone number is invalid');
                }

                // Validate email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    isValid = false;
                    showError(emailInput, 'Please enter a valid email address');
                    errors.push('Email is invalid');
                }

                // Validate address
                if (addressInput.value.trim().length < 10) {
                    isValid = false;
                    showError(addressInput, 'Please enter a complete address (at least 10 characters)');
                    errors.push('Address is too short');
                }

                // Validate city
                if (cityInput.value.trim().length < 2) {
                    isValid = false;
                    showError(cityInput, 'Please enter a valid city name');
                    errors.push('City is invalid');
                }

                // Validate state
                if (stateInput.value.trim().length < 2) {
                    isValid = false;
                    showError(stateInput, 'Please enter a valid state/province name');
                    errors.push('State is invalid');
                }

                // Validate pincode
                if (pincodeInput.value.trim().length < 4) {
                    isValid = false;
                    showError(pincodeInput, 'Please enter a valid pincode (at least 4 digits)');
                    errors.push('Pincode is invalid');
                }

                if (!isValid) {
                    e.preventDefault();

                    // Scroll to first error
                    const firstError = bookOrderForm.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }

                    // Show alert with errors
                    alert('Please fix the following errors:\n- ' + errors.join('\n- '));
                }
            });

            function showError(input, message) {
                input.classList.add('border-red-500');
                input.classList.remove('border-green-500');

                // Remove existing error message if any
                const existingError = input.parentElement.querySelector('.custom-error');
                if (existingError) existingError.remove();

                const error = document.createElement('p');
                error.className = 'text-red-500 text-sm mt-1 custom-error';
                error.textContent = message;
                input.parentElement.appendChild(error);
            }
        }

        document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const answer = button.nextElementSibling;
        const toggle = button.querySelector('.faq-toggle');

        // Toggle display
        if(answer.style.display === 'block'){
            answer.style.display = 'none';
            toggle.textContent = '+';
        } else {
            answer.style.display = 'block';
            toggle.textContent = '-';
        }
    });
});
    </script>
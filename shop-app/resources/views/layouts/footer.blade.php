<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>About Us</h5>
                <p>Your one-stop shop for quality products and excellent service. Thank you for visiting!</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                    <li><a href="{{ url('/shop') }}" class="text-white">Shop</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white">Contact</a></li>
                    <li><a href="{{ url('/about') }}" class="text-white">About</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Contact</h5>
                <ul class="list-unstyled">
                    <li>Email: info@shopapp.com</li>
                    <li>Phone: +1 234 567 890</li>
                    <li>
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="bg-light">
        <div class="text-center">
            &copy; {{ date('Y') }} ShopApp. All rights reserved.
        </div>
    </div>
</footer>

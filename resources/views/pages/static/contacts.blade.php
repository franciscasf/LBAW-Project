@extends('layouts.app')

@section('content')
<style>
    .contact-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-header h1 {
        font-size: 3.5rem; 
        color: #8B0000;
        text-align: center;
        margin-bottom: 25px;
        font-weight: 700;
    }

    .contact-details {
        font-size: 1.6rem; 
        line-height: 2.2; 
        color: #555;
        text-align: center;
    }

    .contact-details a {
        color: #8B0000;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.8rem; 
    }

    .contact-details a:hover {
        text-decoration: underline;
    }

    .social-icons {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .social-icons i {
        font-size: 3rem; 
        color: #8B0000;
        transition: color 0.3s ease-in-out;
    }

    .social-icons i:hover {
        color: #a83232;
    }
</style>

<div class="contact-container">
    <div class="contact-header">
        <h1>Contact Us</h1>
    </div>

    <div class="contact-details">
        <p>For assistance or inquiries, feel free to reach out to us:</p>
        <p>Email: <a href="mailto:support@askleic.com">support@askleic.com</a></p>
        <p>Phone: <a href="tel:+123456789">220 123 456</a></p>
        <p>Follow us on social media:</p>
        <div class="social-icons">
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </div>
</div>
@endsection

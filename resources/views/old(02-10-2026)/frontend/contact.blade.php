@extends('layouts.user.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
 <!-- Hero Header -->
    <div class="hero-header">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Contact</h1>
            <p class="hero-subtitle"> <strong>Contact Us </strong>to get high-quality solutions services
            to our clients.</p>
        </div>
    </div>

<section class="contact-section">
    <!-- Map Left -->
    <div class="map">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019747126781!2d-122.41941538468112!3d37.77492977975992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808cd1254321%3A0x1234567890abcdef!2sSan+Francisco%2C+CA!5e0!3m2!1sen!2sus!4v1670000000000!5m2!1sen!2sus" 
            allowfullscreen="" loading="lazy">
        </iframe>
    </div>

    <!-- Contact Form Right -->
    <div class="contact-form">
        <h2>Get in Touch</h2>
        <form method="POST" action="/">
            @csrf
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Subject" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</section>
@endsection

@extends('layouts.layout')
@section('title', 'Contact Us')

@section('content')
<!DOCTYPE html>
<html lang="en">
<body>
    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <h1>Get in Touch</h1>
            <p>We're here to help you with any questions</p>
        </div>
    </section>

    <!-- Contact Content -->
    <main class="contact-main">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="info-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Visit Us</h3>
                        <p>123 KTM Street</p>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-phone"></i>
                        <h3>Call Us</h3>
                        <p>+977  9812344567<br>Mon-Fri: 9am - 5pm EST</p>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-envelope"></i>
                        <h3>Email Us</h3>
                        <p>rsan51154@gmail.com<br>info@dropstore.com</p>
                    </div>
                </div>

                <!-- Contact Form -->
                <form class="contact-form" action="https://api.web3forms.com/submit" method="POST" id="form">
                <input type="hidden" name="access_key"
                                    value="3e901558-9e4a-4377-9ad2-dfe9b66f6aa3" />
                
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    <
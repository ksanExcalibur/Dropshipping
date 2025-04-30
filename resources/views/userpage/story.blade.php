@extends('layouts.layout')
@section('title', ' Story')

@section('content')
<!DOCTYPE html>
<html lang="en">
<body>
    <!-- Main Banner -->
    <section class="banner">
        <div class="banner-content">
            <h1>About Us</h1>
            <img src="{{ asset('/images/banner.png') }}" alt="Banner Image">
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story">
        <div class="container">
            <h2>Our Story</h2>
            <p>Start from student developing mind set to learn coding and join iic than make this project possible</p>
            <p>We are a team of passionate individuals dedicated to creating unique and high-quality products. Our journey began with a simple idea, and through hard work and collaboration, we have turned that idea into a reality.</p>
            <p>Our mission is to provide our customers with the best possible experience, from the moment they visit our website to the moment they receive their order. We believe in transparency, quality, and customer satisfaction.</p>
        </div>
    </section>

    <!-- Design Process Section -->
    <section class="design-process">
        <div class="container">
            <h2>Step By Step Design Process For Every Piece</h2>
            <p>Each design process in step by step to make it simple</p>
            
        </div>
    </section>

    <!-- Designers Section -->
    <section class="designers">
        <div class="container">
            <h2>Designer</h2>
            <div class="designer-profiles">
                <div class="designer">
                    
                    <h3>Mr Ronal</h3>
                </div>
                <div class="Design">
                    
                    <h3>Web</h3>
                </div>
                <div class="Laravel">
                   
                    <h3>Develop</h3>
                </div>
            </div>
        </div>
    </section>

    
@endsection
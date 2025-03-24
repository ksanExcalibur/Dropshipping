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
            <img src="{{ asset('/images/about.png') }}" alt="Banner Image">
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story">
        <div class="container">
            <h2>Our Story</h2>
            <p>Start from student developing mind set to learn coding and join iic than make this project possible</p>
            <img src="path-to-image.jpg" alt="Gold Necklace and Mirror with Flowers">
        </div>
    </section>

    <!-- Design Process Section -->
    <section class="design-process">
        <div class="container">
            <h2>Step By Step Design Process For Every Piece</h2>
            <p>Each design process in step by step to make it simple</p>
            <img src="'/images/about.png" alt="Person Wearing Earrings and Ring">
        </div>
    </section>

    <!-- Designers Section -->
    <section class="designers">
        <div class="container">
            <h2>Designer</h2>
            <div class="designer-profiles">
                <div class="designer">
                    <img src="path-to-designer1.jpg" alt="Designer 1">
                    <h3>Mr Ronal</h3>
                </div>
                <div class="Design">
                    <img src="path-to-designer2.jpg" alt="Designer 2">
                    <h3>Web</h3>
                </div>
                <div class="Laravel">
                    <img src="path-to-designer3.jpg" alt="Designer 3">
                    <h3>Develop</h3>
                </div>
            </div>
        </div>
    </section>

    
@endsection
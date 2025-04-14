@extends('layouts.layout')

@section('title', 'Shop')

@section('content')
<!DOCTYPE html>
<html lang="en">
<body>
  
    <div class="container">
        <h2 class="text-center">All Products</h2>
        <div class="row mb-4">
            <div class="col-md-3">
                <form method="GET" action="">
               
        <div class="pagination" role="navigation" aria-label="Product pagination">
            <a href="#" aria-label="Previous page">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#" aria-label="Next page">Next &raquo;</a>
        </div>
    </div>
</body>
</html>
@endsection
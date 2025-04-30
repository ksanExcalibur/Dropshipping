@extends($layout)

@section('title', 'Edit Profile')

@section('content')
<style>
  .modern-profile-card {
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    background: #fff;
    border: none;
    max-width: 430px;
    margin: 0 auto;
    padding: 2.5rem 2rem 2rem 2rem;
  }
  .modern-profile-avatar {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #0d6efd;
    margin-bottom: 1rem;
    box-shadow: 0 4px 16px rgba(13,110,253,0.08);
    background: #f8f9fa;
  }
  .modern-profile-form .form-control {
    border-radius: 0.75rem;
    font-size: 1.08rem;
    padding: 0.75rem 1rem;
    border: 1.5px solid #e3e6ea;
    background: #f8f9fa;
    transition: border-color 0.2s;
  }
  .modern-profile-form .form-control:focus {
    border-color: #0d6efd;
    background: #fff;
    box-shadow: 0 0 0 0.15rem rgba(13,110,253,.08);
  }
  .modern-profile-form label {
    font-weight: 600;
    margin-bottom: 0.4rem;
    color: #212529;
  }
  .modern-profile-form .btn-success {
    border-radius: 0.75rem;
    font-size: 1.1rem;
    padding: 0.7rem 0;
    font-weight: 600;
    background: linear-gradient(90deg,#0d6efd 60%,#198754 100%);
    border: none;
    transition: background 0.2s;
  }
  .modern-profile-form .btn-success:hover {
    background: linear-gradient(90deg,#198754 60%,#0d6efd 100%);
  }
  @media (max-width: 600px) {
    .modern-profile-card {
      padding: 1.2rem 0.5rem 1.5rem 0.5rem;
      max-width: 100%;
    }
    .modern-profile-avatar {
      width: 90px;
      height: 90px;
    }
  }
</style>

<div class="container mt-5">
  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="modern-profile-card">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="modern-profile-form">
      @csrf
      @method('PUT')

      <div class="text-center mb-4">
        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('/images/default-avatar.png') }}" class="modern-profile-avatar" alt="Profile Image">
        <div class="mt-2">
          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" style="max-width: 250px; margin: 0 auto;">
          @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $user->address) }}</textarea>
        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <button class="btn btn-success w-100 mt-2">Update Profile</button>
    </form>
  </div>
</div>
@endsection

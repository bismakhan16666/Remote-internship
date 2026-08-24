<!--Lec 12 Creating Layouts with Blade for Reusable Templates-->

@extends('layouts.app')
@section('scripts')
<script>
    alert('Hi! Welcome to the Student Management System')
</script>

@endsection
@section('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
        }

        .header {
            background: #1a1a2e;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .header h1 {
            font-size: 32px;
            letter-spacing: 1px;
        }
        .header h1 span {
            color: #f5c842;
        }

        .nav {
            background: #16213e;
            padding: 12px 0;
            text-align: center;
            border-bottom: 3px solid #f5c842;
        }
        .nav a {
            color: white;
            padding: 10px 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
            border-radius: 5px;
        }
        .nav a:hover {
            background: #f5c842;
            color: #1a1a2e;
        }
        .nav a.active {
            background: #f5c842;
            color: #1a1a2e;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
        }
        .container h2 {
            color: #1a1a2e;
            font-size: 32px;
            margin-bottom: 25px;
            border-bottom: 4px solid #f5c842;
            padding-bottom: 15px;
        }
        .container p {
            line-height: 1.8;
            color: #555;
            margin-bottom: 18px;
            font-size: 16px;
        }
        .container h3 {
            color: #1a1a2e;
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 12px;
        }

        .footer {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 25px 0;
            margin-top: 50px;
        }
        .footer p {
            margin-bottom: 8px;
        }
        .footer a {
            color: #f5c842;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
    @endsection

@section('container')
   
        <h2>About Us</h2>
        <p>
            <h4>Name : {{$name}}</h4> {{-- Lec9 Passing Data fron route to view --}}
            <h4>Email : {{$email}}</h4><br>
            Welcome to the <strong>Student Management System</strong>. This platform is designed to help 
            educational institutions manage student records, academic data, and administrative 
            tasks efficiently and effectively.
        </p>

        <h3>Our Mission</h3>
        <p>
            Our mission is to provide a simple, secure, and reliable system that helps 
            schools, colleges, and universities manage their students with ease. We aim 
            to reduce paperwork and save time for administrators and teachers.
        </p>

        <h3>Our Vision</h3>
        <p>
            To become the most trusted student management solution that connects students, 
            teachers, and parents through a single platform, making education management 
            simple and accessible for everyone.
        </p>

        <h3>Why Choose Us</h3>
        <p>
            Our system is easy to use, affordable, and packed with all the features you 
            need to manage student data, attendance, grades, and communication. We are 
            committed to providing excellent support and continuous improvement.
        </p>

        <h3>Our Team</h3>
        <p>
            We are a dedicated team of professionals with years of experience in education 
            and technology. Our goal is to make student management stress-free for 
            educational institutions of all sizes.
        </p>
  @endsection  

    

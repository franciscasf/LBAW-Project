@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f7fb;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .about-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 50px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
    }

    .about-container:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    }

    .about-header h1 {
        font-size: 4rem;
        color: #9d1b1b;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .about-header img {
        display: block;
        margin: 0 auto;
        max-width: 120px;
        border-radius: 50%;
        margin-bottom: 20px;
    }

    .about-intro {
        font-size: 1.8rem;
        line-height: 1.8;
        color: #555;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 300;
    }

    .about-container h2 {
        font-size: 2.6rem;
        color: #9d1b1b;
        margin-top: 40px;
        margin-bottom: 15px;
        text-align: left;
    }

    .about-container p {
        font-size: 1.6rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 25px;
        text-align: justify;
    }

    .about-container ul {
        list-style-type: square;
        padding-left: 25px;
        margin-bottom: 25px;
    }

    .about-container ul li {
        font-size: 1.6rem;
        margin-bottom: 12px;
        color: #555;
    }

    .about-container ul li strong {
        color: #212529;
    }

    .about-container a {
        color: #9d1b1b;
        text-decoration: none;
    }

    .about-container a:hover {
        text-decoration: underline;
    }

    .about-header i {
        font-size: 6rem; 
        color: #9d1b1b;
        display: block;
        margin: 0 auto 20px auto;
    }

    .highlight {
        font-weight: bold;
        color: #9d1b1b;
    }

    @media (max-width: 768px) {
        .about-container {
            padding: 20px;
        }

        .about-header h1 {
            font-size: 3rem;
        }

        .about-intro {
            font-size: 1.4rem;
        }

        .about-container h2 {
            font-size: 2rem;
        }

        .about-container p {
            font-size: 1.3rem;
        }

        .about-header i {
            font-size: 4rem;
        }
    }
</style>

<div class="about-container">
    <div class="about-header">
        <div style="text-align: center;">
            <i class="fa-solid fa-users"></i>
        </div>
        <h1>About Us</h1>
    </div>
    <p class="about-intro">
        <span class="highlight">AskLEIC</span> is a platform developed by a group of four dedicated <span class="highlight">L.EIC</span> students from <span class="highlight">FEUP</span>. Our mission is to centralize and unite the students of our course, fostering an environment of collaboration and mutual growth. By bringing all course-related questions and answers into one place, we aim to enhance communication and simplify the process of sharing knowledge.
    </p>

    <h2>Why AskLEIC?</h2>
    <p>
        We designed <span class="highlight">AskLEIC</span> to address the need for an organized, reliable, and interactive space for students to clarify doubts, learn from one another, and contribute to a growing pool of academic knowledge. Our platform empowers students to ask questions, provide answers, and engage in meaningful discussions.
    </p>
    <p>
        A key highlight is the ability for teachers to verify answers, ensuring that information shared on the platform is both accurate and trustworthy. This unique feature bridges the gap between peer learning and academic oversight, making <span class="highlight">AskLEIC</span> a reliable resource for all <span class="highlight">L.EIC</span> students.
    </p>

    <h2>Our Vision</h2>
    <p>
        As students ourselves, we understand the challenges of managing coursework and accessing reliable resources. Our vision is to make <span class="highlight">AskLEIC</span> a trusted hub where every student feels supported, every question finds an answer, and the <span class="highlight">L.EIC</span> community grows stronger together.
    </p>

    <h2>Meet the Team</h2>
    <ul>
        <li>Beatriz Pereira</li>
        <li>Francisca Fernandes</li>
        <li>Luciano Ferreira</li>
        <li>Tomás Telmo</li>
    </ul>
</div>
@endsection

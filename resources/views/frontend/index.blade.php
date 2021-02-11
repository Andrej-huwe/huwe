@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <!--main page -->
    <div class="section-main">
        <div class="jumbotron jumbotron-fluid text-right vertical-center">
            <div class="container flex-column">
                <h1 class="masthead-heading text-uppercase mb-0">Učenie sa stáva <br> jednoduchším</h1>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit<br>
                    Etiam et purus a odio finibus bibendum in sit amet leo<br>
                    Mauris feugiat erat tellus. behind the word mountains.</p>
                <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group">
                        <button class="btn btn-start btn-lg text-white" href="www.google.sk">Začať</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--plan page -->
    <div class="plan-page">
        <div class="jumbotron jumbotron-fluid text-left">
            <div class="container flex-column ">
                <h1 class="text-uppercase text-center">Učebná plán</h1>
                <div class="row justify-content-md-center">
                    <div class="col col-md-3">
                        <h2>Efektívnosť</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            Etiam et purus a odio finibus bibendum in sit amet leo</p>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col col-md-3">
                        <h2>Efektívnosť</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            Etiam et purus a odio finibus bibendum in sit amet leo</p>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col col-md-3">
                        <h2>Efektívnosť</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            Etiam et purus a odio finibus bibendum in sit amet leo</p>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col col-md-3">
                        <h2>Efektívnosť</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            Etiam et purus a odio finibus bibendum in sit amet leo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="information-page">
        <div class="jumbotron jumbotron-fluid text-right vertical-center mb-0">
            <div class="container flex-column">
                <h1 class="masthead-heading">S kýmkoľkvek, kdekoľvek</h1>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit<br>
                    Etiam et purus a odio finibus bibendum in sit amet leo<br>
                    Mauris feugiat erat tellus. behind the word mountains.</p>
            </div>
        </div>
    </div>
    <footer>
        <div class="jumbotron jumbotron-fluid mb-0 text-center">
            <h1>Footer</h1>
        </div>
    </footer>
@endsection
@section('style')
    <style>
        .main-page h1 {
            font-size: 3rem;
        }
        .section-main .jumbotron {
            background: url("https://huwe.test/images/main-pagepsd.jpg?a6b3127c03ec1f9e734a9002e594ada2") no-repeat;
            width: 100%;
        }
        .plan-page .jumbotron {
            background: url("https://huwe.test/images/our-plan.jpg?9873fd28658b0f41ead12c25c101b00e") no-repeat center center;
        }
        .plan-page .col {
            margin-bottom: 15%;
        }
        .plan-page h1 {
            margin-bottom: 5%;
        }
        .information-page .jumbotron {
            width: 100%;
            background: url("https://huwe.test/images/information.jpg?10bf8913d90bcf75d15f9a99b4429987") no-repeat left center;
        }
        footer .jumbotron {
            height: 200px;
        }
        .jumbotron {
            width: 100%;
            height: 768px;
            background-size: 100% 100%;
        }
        .vertical-center {
            min-height: 100%;
            min-height: 100vh;

            display: flex;
            align-items: center;
        }
        .btn-start {
            background: #622161;
        }
        @media only screen and (max-width: 900px) {
            .section-main .jumbotron {
                background: none;
            }
            .plan-page .jumbotron {
                background: none;
            }
            .information-page .jumbotron {
                background: none;
            }
        }
    </style>
@endsection

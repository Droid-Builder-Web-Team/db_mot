@extends('layouts.home')

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .overlay{
                color: #111629;
                z-index:999;
            }
        </style>
    </head>
    <body >
        <div class="flex-center position-ref full-height" style="background: url('https://droidbuilders.uk/wp-content/uploads/2020/09/DBUKBG.jpg') no-repeat;
        background-position:center; background-size:cover;">

            <div class="content">

                <div class="title m-b-md">
                    Droid Builder Club Portal
                </div>

                <div class="sub-title m-b-md">
                    Please Log in or Register to proceed
                </div>

                <div class="buttons">
                    <a href="{{ route('login') }}" role="button" class="btn m-3 btn-lg btn-auth">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" role="button" class="btn m-3 btn-lg btn-auth">{{ __('Register') }}</a>
                </div>

            </div>
        </div>
    </body>
</html>

@extends('admin.layouts.main_auth')
@section('title')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
:root {
  --font_family:  'Roboto', sans-serif;
  --main_color: #001C40;
  --main_bg: #FFD43B;
  --login_bg: #001C40;
  --white_bg:#ffffff;
  --onehundred_percent:100%;
  --black_color:#000;
  --back_bg:#000000;
  --margin_0:0px;
  --padding_0:0px;
  --none:none;
  --transparent:transparent;
  --font_14:14px;
  --font_13:13px;
  --font_15:15px;
  --font_17:17px;
  --font-22:22px;
  --nine-900:900;
  --center:center;
  --one_five:1.5;
  --radius_5px:.357rem;
  --vh_100:100vh;
  --h_45:45px;
  --auto:auto;
  --w_960px: 960px;
  --w_316:316px;
  --w_500: 500;
  --w300:300px;
  --flex-element:flex;
  --wrap-element:wrap;
  --radius_10:10px;
  --px_1:1px;
  --e_flex:flex;
  --shadow-form:1px 1px 10px #00000070;
  --hidden-element:hidden;
  --bg-cover:cover;
  --cursor_pointer:pointer;
  --p_wrap_login:100px 100px 50px 100px;
  --shadow_login:0px 0px 20px 0px #0000003b;
}
* {
	margin: var(--margin_0); 
	padding: var(--padding_0); 
	box-sizing: border-box;
}
body, html {
	height: var(--onehundred_percent);
  font-family: var(--font_family);
  background: var(--white_bg);
}
/*---------------------------------------------*/
a {
 font-family: var(--font_family);
	font-size: var(--font_14);
	color: var(--black_color);
	margin: var(--margin_0); 
}
a:focus {
	outline: var(--none) !important;
}
a:hover {
	text-decoration: var(--none);
}
/*---------------------------------------------*/
h1,h2,h3,h4,h5,h6 {
	margin: var(--margin_0); 
}
p {
 font-family: var(--font_family);
	font-size: var(--font_14);
	color: var(--black_color);
	margin: var(--margin_0); 
}
ul, li {
	margin: var(--margin_0); 
	list-style-type: var(--none);
}
/*---------------------------------------------*/
input {
	outline: var(--none);
	border: var(--none);
}
textarea:focus, input:focus {
  border-color: var(--transparent) !important;
}
input:focus::-webkit-input-placeholder { color:var(--transparent); }
input:focus:-moz-placeholder { color:var(--transparent); }
input:focus::-moz-placeholder { color:var(--transparent); }
input:focus:-ms-input-placeholder { color:var(--transparent); }
textarea:focus::-webkit-input-placeholder { color:var(--transparent); }
textarea:focus:-moz-placeholder { color:var(--transparent); }
textarea:focus::-moz-placeholder { color:var(--transparent); }
textarea:focus:-ms-input-placeholder { color:var(--transparent); }
input::-webkit-input-placeholder { color: var(--black_color); }
input:-moz-placeholder { color: var(--black_color); }
input::-moz-placeholder { color: var(--black_color); }
input:-ms-input-placeholder { color: var(--black_color); }
textarea::-webkit-input-placeholder { color: var(--black_color); }
textarea:-moz-placeholder { color: var(--black_color); }
textarea::-moz-placeholder { color: var(--black_color); }
textarea:-ms-input-placeholder { color: var(--black_color); }
/*---------------------------------------------*/
button {
	outline: var(--none) !important;
	border: var(--none);
	background: var(--transparent);
}
button:hover {
	cursor:var(--cursor_pointer);
}
iframe {
	border: var(--none) !important;
}
/*////////////////////////////////////////////////////////////////// */
.txt1 {
  font-family: var(--font_family);
  font-size: var(--font_13);
  line-height: var(--one_five);
  color: var(--black_color);
}
.txt2 {
  font-family: var(--font_family);
  font-size: var(--font_13);
  line-height: var(--one_five);
  color: var(--main_color) !important;
  text-align:var(--center);
  font-weight: 600 !important;
  width: var(--onehundred_percent);
}
/*////////////////////////////////////////////////////////////////// */
.limiter {
  width: var(--onehundred_percent);
  margin: 0 var(--auto);
}
.container-login100 {
  width: var(--onehundred_percent);
  min-height: var(--vh_100);
  display: var(--flex-element);
  justify-content: var(--center);
  align-items: var(--center);
  padding: var(--font_15);
  background: var(--login_bg);
  border-bottom-left-radius: var(--onehundred_percent);
  background-size: var(--bg-cover);
}
.wrap-login100 {
  width: var(--w_960px);
  background: rgb(255, 255, 255);
  border-radius: var(--radius_10);
  overflow: hidden;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display:var(--e_flex);
  flex-wrap: wrap;
  justify-content: space-between;
  padding: var(--p_wrap_login);
  box-shadow: var(--shadow-form);
}

/*------------------------------------------------------------------
[  ]*/
.login100-pic {
  width: var(--w_316);
}
.login100-pic img {
  max-width: 350px;
  display: block;
  margin-left: var(--auto);
  margin-top: var(--auto);
  margin-right: var(--auto);
}
/*------------------------------------------------------------------ */
.login100-form {
  width: var(--w300);
}
.login100-form-title {
  font-family: var(--font_family);
  font-size: var(--font-22);
  color: var(--black_color);
  line-height: 1.9;
  text-align: var(--center);
  font-weight: 900;
  width: var(--onehundred_percent);
  display: block;
  padding-bottom: 30px;

}
/*---------------------------------------------*/
.wrap-input100 {
  position: relative;
  width: var(--onehundred_percent);
  z-index: 1;
  margin-bottom: 10px;
}

.input100 {
  font-family: var(--font_family);
  font-size: var(--font_15);
  line-height: 1.5;
  color: var(--back_bg);
  display: block;
  width: var(--onehundred_percent);
  background: #f5f5f5;
  height: var(--h_45);
  border-radius: .375rem;
  padding: 0 30px 0 68px;
  border: 1px solid #d4d4d4;
}
.input100:active , .input100:focus{
   background: var(--white_bg);
  border: var(--px_1) solid var(--main_bg) !important;
}
.bx {
  font-size: var(--font_17);
}
/*------------------------------------------------------------------
[ Focus ]*/

.symbol-input100 {
  font-size: var(--font_15);
  display: var(--flex-element);
  align-items: var(--center);
  position: absolute;
  border-radius: 25px;
  bottom: 0;
  left: 0;
  width: var(--onehundred_percent);
  height: var(--onehundred_percent);
  padding-left: 25px;
  pointer-events:var(--none);
  color: var(--black_color);
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}
.symbol-input100 i,.fas{
  color: var(--main_color) !important;
  font-size: 20px;
}
.swal-button:focus {
  outline: var(--none);
  box-shadow:var(--none)!important;
}
.swal-modal {
  opacity: 0;
  pointer-events: var(--none);
  background-color: #fff;
  text-align:var(--center);
  border-radius: var(--radius_5px);
  position: static;
  margin: 20px var(--auto);
  width: 25%;
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: scale(1);
  transform: scale(1);
  -webkit-transform-origin: 50% 50%;
  transform-origin: 50% 50%;
  z-index: 10001;
  transition: opacity .2s,-webkit-transform .3s;
  transition: transform .3s,opacity .2s;
  transition: transform .3s,opacity .2s,-webkit-transform .3s;
}
@media (max-width: 790px){
  .swal-modal{
    width: 70%;
  }
} 
/*------------------------------------------------------------------
[ Button ]*/
.container-login100-form-btn {
  width: var(--onehundred_percent);
  display: var(--flex-element);
  flex-wrap:  var(--wrap-element);
  justify-content: var(--center);
  padding-top: 20px;
}
input[type=submit]{
  font-size: var(--font_15);
  background: linear-gradient(var(--back_bg) 5%, var(--back_bg) var(--onehundred_percent));
  border: var(--px_1) solid var(--back_bg);
  color: rgb(255, 255, 255);
  font-weight: bold;
  cursor:var(--cursor_pointer);
  width: var(--onehundred_percent);
  border-radius: var(--radius_5px);
  padding: 10px 0;
  outline:none;
  }
  input[type=submit] {
    font-size: var(--font_17);
    background: var(--main_bg);
    border: var(--px_1) solid var(--main_bg);
    color: var(--black_color);
    font-weight: var(--w_500);
    cursor: var(--cursor_pointer);
    width: var(--onehundred_percent);
    border-radius: var(--radius_5px);
    padding: 10px 0;
    outline: var(--none);
    font-family: var(--font_family);
}

.login100-form-btn {
  font-family: var(--font_family);
  font-size: var(--font_15);
  line-height: 1.5;
  color: var(--black_color);
  text-transform: uppercase;
  width: var(--onehundred_percent);
  height: 50px;
  border-radius: 25px;
  background: #0251b9;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: var(--flex-element);
  justify-content:var(--center);
  align-items: var(--center);
  padding: 0 25px;
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}
.login100-form-btn a:hover {
  background: #333333;
}
/*------------------------------------------------------------------
[ Responsive ]*/
@media (max-width: 992px) {
  .wrap-login100 {
    padding: 177px 90px 33px 85px;
  }

  .login100-pic {
    width: 35%;
  }

  .login100-form {
    width: 50%;
  }
}
@media (max-width: 768px) {
  .wrap-login100 {
    padding: 50px 80px 33px 80px;
  }

  .login100-pic {
    display: none;
  }

  .login100-form {
    width: var(--onehundred_percent);
  }
}

@media (max-width: 576px) {
  .wrap-login100 {
    padding: 50px var(--font_15) 33px var(--font_15);
  }
}


/*------------------------------------------------------------------
[ Alert validate ]*/

.validate-input {
  position: relative;
}
.field-icon {
  float: right;
  margin-right: 15px;
  margin-top: -31px;
  position: relative;
  z-index: 2;
  font-size: 18px;
  color: var(--black_color);
}
.fa{
  color: var(--black_color);
}
.fas, .far{
  color: var(--black_color);
}
.swal-button{
  background: var(--main_color) !important;
  border-radius: var(--radius_5px);
}
.swal-title{
  color: var(--black_color);
  text-transform: uppercase;
}
.swal-icon--info{
  border-color:var(--black_color) !important;
}
.swal-icon--info:after, .swal-icon--info:before{
  background-color: var(--black_color);
}
.swal-icon--success__ring{
  border: 2px solid rgb(78 208 5);
}
.swal-icon--success__line{
  background-color:rgb(78 208 5);
  height: 2px;
}
.swal-icon--success__line--tip {
  width: 24px;
  left: 13px;
  top: 46px;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  -webkit-animation: animateSuccessTip .75s;
  animation: animateSuccessTip .75s;
}
.swal-text{
  color: var(--black_color);
  text-align: var(--center);
  font-weight: 500;
}
.swal-icon--error__line {
  position: absolute;
  height: 2px !important;
  width: 47px;
  background-color: #d20303 !important;
  display: block;
  top: 37px;
  border-radius: var(--radius_5px);
}
.swal-overlay {
 
  background-color: rgb(0 0 0 / 88%) !important;
 
}
.swal-icon--error {
  border-color: #d20303 !important;
  -webkit-animation: animateErrorIcon .5s;
  animation: animateErrorIcon .5s;
}
.swal-icon {
  width: 80px;
  height: 80px;
  border-width: 2px !important;
  border-style: solid;
  border-radius: 50%;
  padding: 0;
  position: relative;
  box-sizing: content-box;
  margin: 20px var(--auto);
}
.swal-icon--warning__body, .swal-icon--warning__dot {
  position: absolute;
  left: 50%;
  background-color: #f37a11 !important;
}
.swal-icon--warning__body {
  width: 3px !important;
  height: 47px;
  top: 10px;
  border-radius: 2px;
  margin-left: -2px;
}
.swal-icon--warning__dot {
  width: 3px !important;
  height: 3px !important;
  border-radius: 50%;
  margin-left: -1.3px !important;
  bottom: -11px;
}
.swal-icon--warning {
  border-color: #f37a11 !important;
  -webkit-animation: pulseWarning .75s infinite alternate;
  animation: pulseWarning .75s infinite alternate;
}
.ph{
  position: absolute;
  top: 16%;
  padding-bottom:5px;
  font-weight: 900;
}
    </style>
    <head>
        <title>Đăng nhập quản trị | Website quản trị v2.0</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    </head>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('admin/dist/img/team.jpg') }}" alt="IMG">
                </div>
                <!--=====TIÊU ĐỀ======-->
                <form class="login100-form validate-form" action="" method="post">
                  @csrf
                    <span class="login100-form-title">
                        <b>ĐĂNG NHẬP HỆ THỐNG </b>
                    </span>
                    @if (session('danger'))
                        <p class="login-box-msg text-danger">{{ session('danger') }}</p>
                    @endif
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="email" placeholder="Tài khoản quản trị" name="email" id="username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class='bx bx-user'></i>
                        </span>
                        <div class="col-12">
                            @if ($errors->first('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="wrap-input100 validate-input">
                        <input autocomplete="off" class="input100" name="password" type="password" placeholder="Mật khẩu"
                               id="password-field">
                        <span toggle="#password-field" class="bx fa-fw bx-hide field-icon click-eye"></span>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class='bx bx-key'></i>
                        </span>
                        <div class="col-12">
                            @if ($errors->first('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
    
                    <!--=====ĐĂNG NHẬP======-->
                    <div class="container-login100-form-btn">
                        @csrf
                        <input type="submit" value="Đăng nhập" id="submit" onclick="validate()" />
                    </div>
                    <!--=====LINK TÌM MẬT KHẨU======-->
                    <div class="text-right p-t-12">
                        <a class="txt2" href="/forgot.html">
                            Bạn quên mật khẩu?
                        </a>
                    </div>
                </form>
                <!--=====FOOTER======-->
                <div class="text-center p-t-70 txt2 mt-3">
                    Phần mềm quản lý đặt tour du lịch <i class="far fa-copyright" aria-hidden="true"></i>
                    <script type="text/javascript">document.write(new Date().getFullYear());</script> <a
                        class="txt2" href="#"> Code bởi Bích Trâm </a>
                </div>
            </div>
        </div>
    </div>
    <!--Javascript-->
    <script src="/js/main.js"></script>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script type="text/javascript">
        //show - hide mật khẩu
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "email"
            } else {
                x.type = "password";
            }
        }
        $(".click-eye").click(function () {
            $(this).toggleClass("bx-show bx-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "email");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@stop
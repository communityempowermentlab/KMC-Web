<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="title" content="CEL">
    <meta name="Keywords" content="KMC,CEL">
    <meta name="description" content = "KMC,CEL" />
    <meta property="og:site_name" content="CEL">
    <meta property="og:title" content="CEL"/>  
    <meta property="og:type" content="website" />
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:url" content="http://52.201.54.81/kmcV2Testing/RegistrationManagement/AddFacility" />
    <meta property="og:description" content="CEL"/>  
    <meta property="og:image" itemprop="image" content="http://52.201.54.81/kmcV2Testing/assets/kmc.png"/>  
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />

    <link rel="shortcut icon" href="<?php echo base_url('/assets/kmc.png');?>" type="image/x-icon"> 
    <title>Lounge Amenities detail form</title>
    <!-- Tell the browser to be responsive to screen width -->
    

    <!-- Bootstrap 3.3.7 -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/admin/bower_components/Ionicons/css/ionicons.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/bootstrap-extended.min.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <style type="text/css">
      span#showImages {
      position: relative;
      top: 50px;
      }
      .photosize{
        width: 80px !important;
        height: 70px !important;
      }
      .btn_default {
        background-color: #0d4982;
        color: #fff;
      }
      .register-box-body {
        background: #fff;
        padding: 20px;
        border-top: 0;
        color: #666;
      }
      .red {
        background-color: rgb(244, 67, 54) !important;
      }
      .btn-block{display: inline-block; width: 120px !important;}
      .login-box, .register-box{width: 800px !important; margin: 4% auto;}
    
      a.btn{border-radius: 0px !important;}
      .divPadding{padding: 0px !important;}
      #showImages img {
           border: 0;
           margin-top: -60px;
      }

      .set_div_img, .set_div_img2{
        width: 30px !important;
        padding-top: 5px;
      }             
      .set_div_msg{ text-align: center;}              
      /*.success_msg{
        width: 280px;
        min-height: 50px;
        position: fixed;  
        top: 50px;
        right: 0px;   
        background: #4BB543;                
        color: #fff;                
        z-index: 1000000;               
        padding: 15px 5px;                
        border: 1px solid #fff;               
        border-radius: 15px;
      }  
*/      
      .success_msg {
          width: 95% !important;
          min-height: 50px !important;
          position: relative !important;
          top: 0 !important;
          right: 0px !important;
          background: #dff0d8 !important;
          color: #3c763d !important;
          z-index: 1000000 !important;
          padding: 12px 5px 15px 5px !important;
          border: 1px solid #d6e9c6 !important;
          border-radius: 4px !important;
          margin: 0 auto 15px !important;
          font-weight: 500 !important;
          font-size: 16px !important;
      }

      .unsuccess_msg{
        width: 280px;
        min-height: 50px;
        position: fixed;  
        top: 50px;
        right: 0px;   
        background: #b21e23;                
        color: #fff;                
        z-index: 1000000;               
        padding: 15px 5px;                
        border: 1px solid #fff;               
        border-radius: 15px;
      }            
      .set_div_img2{
        text-align: right; cursor: pointer;
       }             
      .set_img_tick{
          height: 20px;
      }
      .btn.dropdown-toggle.btn-default {
        border-radius: 0px !important;
      }

      .set_all_btn{
          float: right;
          margin-top: 25px;
      }

      .att_img{
            width: 50px !important;
            height: 34px;
            border: 1px solid #ddd;
            padding: 0px 13px;
            font-size: 23px;
            float: right;
            position: absolute;
            top: 25px;
            right: 15px;
      }
      .set_text_a_css{
        height: 50px !important;
      }
      .close{
            position: absolute;
            float: right;
            right: 15px;
            top: 18px;
            z-index: 1000;
        }
  .set_remove_btn{padding: 30px 15px 0 15px; text-align: right;} 
    .set_remove_btn button{background: red; border-color: red; color: #fff;}  
    .set_remove_btn button.plus_btn{background: #286090; border-color: #286090; color: #fff;}   
  .show_img2{width: 80px; height: 70px; border: 1px solid #ddd;}

    </style>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/bootstrap-select.min.css"/>
    <style type="text/css">
  .social_icon div{
    display: inline;
  }
  .divPadding{padding-right: 0px; padding-left: 0px;}
  /*.set_icons a img{height: 50px;}*/
  .social_icon div a i{
    color: #fff;
    
  }
  .bdr{border: 1px solid red;}
  .social_icon{padding: 10px 0;}
  .social_icon a{
      font-size: 20px;
      background: #fff !important;
      padding: 2px 12px;
      border-radius: 10px;
  }
  .img1{height: 48px;}
  .img2{height: 44px;}
  .img3{height: 44px;}
  .social_icon a{border-radius: 50% !important; padding: 4px 0px !important; margin-left: 5px;}
  .logoimg{height: 80px; float: left;}
  /* media query for respoinsive */
  @media (min-width: 200px) and (max-width: 767px) {
    
    .set_outer_footer{position: absolute;}
    .set_outer_footer .col-xs-12.col-sm-4, .sets_icons{text-align: center;}
  } 
  @media (min-width: 768px) {
    .sets_icons{
      text-align: right;
    }
    .set_outer_footer{position: fixed; bottom: 0}
  }
  body{
    font-family: Graphik LCG Web, Graphik Arabic Web Regular, -apple-system, BlinkMacSystemFont, Helvetica Neue, Helvetica, Arial, Lucida Grande, Sans-Serif;
  }


  .login-box, .register-box{    
    width: 800px !important;
      margin: 0% auto;
  }
  .set_headers{
    background: #fff;
    padding: 10px;
  }
  .set_h_txt {
    /*color: #337ab7;*/
      font-size: 42px;
      text-transform: capitalize;
      font-weight: bold
  }
  .login-page, .register-page{background: #f9f9f9;}
  .register-box-body{
    color: #333 !important;
      box-shadow: 1px 2px 4px 2px #eee;
      margin-bottom: 30px;
  }
  .form-group.center{background: transparent !important;}
  .form-group.center p {
      text-align: left !important;
      padding: 10px 0 0px !important;
  }
  .form-control {
      height: auto;
  }


  .set_div_img00{
            border: 2px solid #dedadad9;
            padding: 5px;
            width: 228px;
            right: 15px;
            top: 0;
    }
    .set_div_img00 img{    
        height: 150px;
        width: 212px;
    }

    

    .set_img{
        margin: 0;
        width: 212px;
        text-align: center;
        position: absolute;
        top: 77px;
        background: rgba(0, 0, 0, 0.6);
        font-size: 16px;
        color: #fff !important;
        display: none;
        height: 150px;
        padding-top: 60px;
    }
    .set_div_img00:hover .set_img{display: block;}
    .set_img a{color: red !important;}

    .del_img{
        margin: 0;
        width: 44px;
        text-align: center;
        top: 6px;
        background: transparent;
        font-size: 16px;
        color: red !important;
        right: 6px;
        border: 1px solid #ddd;
        margin-top: 5px;
    }
    .showFile img{height: 150px;}

        .show_img_data .showFile{width:228px;}
      .file-upload{display:block;text-align:center;font-family: Helvetica, Arial, sans-serif;font-size: 12px;}
        .file-upload .file-select{display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
        .file-upload .file-select .file-select-button{background:#dce4ec;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
        .file-upload .file-select .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
        .file-upload .file-select:hover{border-color:#34495e;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
        .file-upload .file-select:hover .file-select-button{background:#34495e;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
        .file-upload.active .file-select{border-color:#3fa46a;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
        .file-upload.active .file-select .file-select-button{background:#3fa46a;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
        .file-upload .file-select input[type=file]{z-index:100;cursor:pointer;position:absolute;height:100%;width:100%;top:0;left:0;opacity:0;filter:alpha(opacity=0);}
        .file-upload .file-select.file-select-disabled{opacity:0.65;}
        .file-upload .file-select.file-select-disabled:hover{cursor:default;display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;margin-top:5px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
        .file-upload .file-select.file-select-disabled:hover .file-select-button{background:#dce4ec;color:#666666;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
        .file-upload .file-select.file-select-disabled:hover .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
        .show_img_data{display: none;}


        /* use for upload img */
        .showFile {
            border: 2px solid #dedadad9;
            padding: 5px;width: 200px;
        }
        #loaderShow{display: none;}
        p.deleteFile {
            margin: 0px;
            color: #e0aeae;
        }
        .myProgress {
            width: 100%;
            background-color: #ddd;
        }

        .myBar {
            width: 1%;
            height: 6px;
            background-color: #61bd65;
            margin-top: 7px;
        }
        .loader {
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #3498db;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }
        /* Safari */
        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        span#videoSize {
            float: right;
        }
        .set_red {
          color: red;
        }

        

      .correction{
        color: #E74C3C!important;
      }

      input[type=date] {
          line-height: normal !important;
      }

      .auto_size.form-control {
        min-height: 34px;
            height: 34px;
            width: 335px;
        }

  /* The Modal (background) */
    .modal {
      display: none; /* Hidden by default */
      /*position: fixed; */
      z-index: 1000000; /* Sit on top */
      padding-top: 50px; /* Location of the box */
      /*left: 0;
      top: 0;*/
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
      padding-bottom: 50px;
    }

    /* Modal Content (image) */
    .modal-content {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
      height:100%;
    }

    .close:hover, .close:focus {
      color: #bbb;
      text-decoration: none;
      cursor: pointer;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 35px;
      color: #f1f1f1;
      font-size: 40px;
      font-weight: bold;
      transition: 0.3s;
      opacity: 1.2;
    }
    viewer-pdf-toolbar{
        display: none;
    }

    #outerContainer #mainContainer .toolbar {
      display: none !important; /* hide PDF viewer toolbar */
    }
    #outerContainer #mainContainer #viewerContainer {
      top: 0 !important; /* move doc up into empty bar space */
    }
   .nav>li{
    margin: 0 33%;
   }

   .classic-tabs .nav {
        position: relative;
        overflow-x: auto;
        white-space: nowrap;
        border-radius: .3rem .3rem 0 0;
    }
    .tabs-cyan {
        background-color: #00bcd4 !important;
    }

    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .classic-tabs .nav.tabs-cyan li a.active {
        border-color: #ffeb3b;
    }

    .classic-tabs .nav li a.active {
        color: #fff;
        border-bottom: 3px solid;
    }

  .classic-tabs .nav li a {
        display: block;
        padding: 20px 24px;
        font-size: 13px;
        color: rgba(255,255,255,0.7);
        text-align: center;
        text-transform: uppercase;
        border-radius: 0;
    }

  .nav>li>a:focus, .nav>li>a:hover {
      text-decoration: none;
      border-bottom: 3px solid;
      border-color: #ffeb3b;
      background-color: #00bcd4 !important;
  }


  .floating-form {
  width: 320px;
}

.floating-label {
  position: relative;
  margin-bottom: 20px;
}

.floating-input,
.floating-select {
  font-size: 12px;
  padding: 4px 4px;
  display: block;
  width: 100%;
  height: 30px;
  background-color: transparent;
  border: none;
  border-bottom: 1px solid #757575;
}

.floating-input:focus,
.floating-select:focus {
  outline: none;
  border-bottom: 2px solid #5264AE;
}

.floating-label label {
  color: #575B5F;
  font-size: 14px;
  font-weight: normal;
  position: absolute;
  pointer-events: none;
  left: 5px;
  top: 5px;
  transition: 0.2s ease all;
  -moz-transition: 0.2s ease all;
  -webkit-transition: 0.2s ease all;
}

.floating-input:focus~label,
.floating-input:not(:placeholder-shown)~label {
  top: -18px;
  font-size: 12px;
  color: #5264AE;
}

.floating-select:focus~label,
.floating-select:not([value=""]):valid~label {
  top: -18px;
  font-size: 12px;
  color: #5264AE;
}


/* active state */

.floating-input:focus~.bar:before,
.floating-input:focus~.bar:after,
.floating-select:focus~.bar:before,
.floating-select:focus~.bar:after {
  width: 50%;
}

*,
*:before,
*:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.floating-textarea {
  min-height: 30px;
  max-height: 260px;
  overflow: hidden;
  overflow-x: hidden;
}


/* highlighter */

.highlight {
  position: absolute;
  height: 50%;
  width: 100%;
  top: 15%;
  left: 0;
  pointer-events: none;
  opacity: 0.5;
}


/* active state */

.floating-input:focus~.highlight,
.floating-select:focus~.highlight {
  -webkit-animation: inputHighlighter 0.3s ease;
  -moz-animation: inputHighlighter 0.3s ease;
  animation: inputHighlighter 0.3s ease;
}


/* animation */

@-webkit-keyframes inputHighlighter {
  from {
    background: #5264AE;
  }
  to {
    width: 0;
    background: transparent;
  }
}

@-moz-keyframes inputHighlighter {
  from {
    background: #5264AE;
  }
  to {
    width: 0;
    background: transparent;
  }
}

@keyframes inputHighlighter {
  from {
    background: #5264AE;
  }
  to {
    width: 0;
    background: transparent;
  }
}

.mg20{
  margin: 20px 0;
}


.freebirdSolidBackground {
    background-color: rgb(103, 58, 183);
    color: rgba(255, 255, 255, 1);
}


.freebirdMaterialHeaderbannerLabelContainer {
    -webkit-box-align: stretch;
    box-align: stretch;
    -webkit-align-items: stretch;
    align-items: stretch;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    -webkit-box-flex: 1;
    box-flex: 1;
    -webkit-flex-grow: 1;
    flex-grow: 1;
}

.freebirdMaterialHeaderbannerSectionText {
    font: 400 16px/24px Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
    padding: 8px 8px 8px 42px;
}


.freebirdMaterialHeaderbannerSectionTriangleContainer {
    -webkit-flex-shrink: 0;
    flex-shrink: 0;
    overflow: hidden;
    position: relative;
    width: 18px;
}


.freebirdMaterialHeaderbannerSectionTriangle {
    height: 100%;
    overflow: visible;
    position: absolute;
    width: 90%;
}

.freebirdMaterialHeaderbannerSectionTriangle>polygon {
    stroke-width: 1;
}

.freebirdSolidFill {
    fill: rgb(103, 58, 183);
    stroke: rgb(103, 58, 183);
}
 
h4{
  font-size: 18px;
  margin: 20px;
  color: #000;
  font-weight: 600;
}


.radioCSS .form-radio
{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     display: inline-block;
     position: relative;
     background-color: #f1f1f1;
     color: #666;
     top: 10px;
     height: 30px;
     width: 30px;
     border: 0;
     border-radius: 50px;
     cursor: pointer;     
     margin-right: 7px;
     outline: none;
}
.radioCSS .form-radio:checked::before
{
     position: absolute;
     font: 13px/1 'Open Sans', sans-serif;
     left: 11px;
     top: 7px;
     content: '\02143';
     transform: rotate(40deg);
}
.radioCSS .form-radio:hover
{
     background-color: #f7f7f7;
}
.radioCSS .form-radio:checked
{
     background-color: #f1f1f1;
}
.radioCSS label
{
     font: 13px/1.7 'Open Sans', sans-serif;
     color: #333;
     -webkit-font-smoothing: antialiased;
     -moz-osx-font-smoothing: grayscale;
     cursor: pointer;
} 

.radioCSS .form-checkbox
{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     display: inline-block;
     position: relative;
     background-color: #f1f1f1;
     color: #666;
     top: 10px;
     height: 30px;
     width: 30px;
     border: 0;
     cursor: pointer;     
     margin-right: 7px;
     outline: none;
}
.radioCSS .form-checkbox:checked::before
{
     position: absolute;
     font: 13px/1 'Open Sans', sans-serif;
     left: 11px;
     top: 7px;
     content: '\02143';
     transform: rotate(40deg);
}
.radioCSS .form-checkbox:hover
{
     background-color: #f7f7f7;
}
.radioCSS .form-checkbox:checked
{
     background-color: #f1f1f1;
}

input[type=radio]:focus {
    outline: none !important;
}

input[type=checkbox]:focus {
    outline: none !important;
}
  
.radioCSS{
  margin-bottom: 25px;
}

.mgBT20{
  margin: 0 0 20px 0;
}

.mandatory{
  color: red;
}

#dvPreview img{
  width: 200px;
  height: 200px;
  border: 1px solid #a69494;
 }

 input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance:textfield;
}

.btn-submit{
  background-color: #00bcd4;
  color: #fff;
}

.btn-submit.focus, .btn-submit:focus, .btn-submit:hover {
    color: #fff;
    background-color: #39B2EA;
}
.user_err{
  font-style: italic;
  color: red;
  
}
.send_otp {
  padding: 4px 20px;
  font-size: 15px;
  color: #fff !important;
}


/*media queries*/

@media only screen and (max-width: 765px) {
  .register-box {
    width: 90% !important;
  }
  .nav > li {
    margin: 0 6%;
  }
  #terms-label {
    width: 85%;
  }
  #terms{
    vertical-align: top;
  }
  .modal-body{
    height: 200px!important;
  }
}


@media only screen and (max-width: 480px) {
  .nav > li {
    margin: 0 3%;
  }

}

@media only screen and (max-width: 425px) {
  .nav > li {
    margin: 0 0%;
  }
  .radioCSS .form-checkbox
  {
    height: 25px;
    width: 25px;
  }

  .radioCSS .form-radio {
    height: 25px;
    width: 25px;
  }

}

@media only screen and (max-width: 382px) {
  .nav > li {
    margin: 0 -4%;
  }

  .radioCSS .form-checkbox
  {
    height: 20px;
    width: 20px;
    top: 7px;
  }

  .radioCSS .form-radio {
    height: 20px;
    width: 20px;
    top: 7px;
  }

  .radioCSS label {
    font: 11px/1.7 'Open Sans', sans-serif;
  }

  .radioCSS .form-checkbox:checked::before {
    left: 8px;
    top: 3px;
  }

  .radioCSS .form-radio:checked::before {
    left: 8px;
    top: 3px;
  }


}

/*********************Image zoom start**********************/
.heading_icon{ width: 60px;border:1px solid #e1dbdb;cursor: pointer; }
.image-link {
  cursor: -webkit-zoom-in;
  cursor: -moz-zoom-in;
  cursor: zoom-in;
}
a:focus, a:hover{
  text-decoration: none;
}


/* This block of CSS adds opacity transition to background */
.mfp-with-zoom .mfp-container,
.mfp-with-zoom.mfp-bg {
  opacity: 0;
  -webkit-backface-visibility: hidden;
  -webkit-transition: all 0.3s ease-out; 
  -moz-transition: all 0.3s ease-out; 
  -o-transition: all 0.3s ease-out; 
  transition: all 0.3s ease-out;
}

.mfp-with-zoom.mfp-ready .mfp-container {
    opacity: 1;
}
.mfp-with-zoom.mfp-ready.mfp-bg {
    opacity: 0.8;
}

.mfp-with-zoom.mfp-removing .mfp-container, 
.mfp-with-zoom.mfp-removing.mfp-bg {
  opacity: 0;
}



/* padding-bottom and top for image */
.mfp-no-margins img.mfp-img {
  padding: 0;
}
/* position of shadow behind the image */
.mfp-no-margins .mfp-figure:after {
  top: 0;
  bottom: 0;
}
/* padding for main container */
.mfp-no-margins .mfp-container {
  padding: 0;
}

/* aligns caption to center */
.mfp-title {
  text-align: center;
  padding: 6px 0;
}
.image-source-link {
  color: #DDD;
}
/*********************Image zoom end**********************/

</style>
  </head>
  
  <body class="hold-transition register-page">

    <div class="col-xs-12 col-sm-12 set_headers">
      <?php $this->load->view('admin/registration_header'); ?>
    </div>
    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-10">
      
    </div>
    

    <div id="correction_div"></div>

    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12">&nbsp;</div>

    <div class="register-box">
      
      <div class="register-box-body col-md-12 col-xs-12">
        
        
        
        <div class="tab-content">
        <input type="hidden" id="tab_id" value="<?php echo $tab_id; ?>" name="">
                
        <!-- <span style="color:red;">*</span> Required Fields -->
        <div class="col-sm-12 col-xs-12 divPadding">
          <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

          <div class="input-field col-sm-12 col-xs-12">
            <p id="err_msg"></p>
              <div class="form-group classic-tabs">
                

                <ul class="nav tabs-cyan" id="myClassicTab" role="tablist">
                  <!-- <li class="nav-item <?php if ($tab_id == '') { echo "active"; } ?>">
                    <a class="nav-link  waves-light <?php if ($tab_id == '') { echo "active"; } ?> show" id="profile-tab-classic" data-toggle="tab" href="#home"
                      role="tab" aria-controls="profile-classic" aria-selected="true">Facility Form</a>
                  </li> -->
                  <li class="nav-item active">
                    <a class="nav-link waves-light active" id="follow-tab-classic" data-toggle="tab" href="#menu1" role="tab"
                      aria-controls="follow-classic" aria-selected="false">Lounge Amenities detail form</a>
                  </li>
                  <!-- <li class="nav-item <?php if ($tab_id == '2') { echo "active"; } ?>">
                    <a class="nav-link waves-light <?php if ($tab_id == '2') { echo "active"; } ?>" id="contact-tab-classic" data-toggle="tab" href="#menu2" role="tab"
                      aria-controls="contact-classic" aria-selected="false">Staff Form</a>
                  </li> -->
                  
                </ul>
              </div>
            </div>
          </div>
              
                
                <!-- start tab content -->

          <!--  +++++ First Tab Information +++++++++ -->
          <!-- <div id="home" class="col-sm-12 col-xs-12 divPadding tab-pane fade <?php if ($tab_id == '') { echo "in active"; } ?>">
            <?php $attributes = array('id' => 'submitForm1','class' =>'editpersonalinfo','onsubmit'=>'return validate_form()');
            echo form_open_multipart('RegistrationManagement/saveFacility', $attributes); ?>

              <div class="input-field col-sm-12">

                <div class="col-sm-12 divPadding">

                  <div class="freebirdMaterialHeaderbannerLabelContainer" jsname="bLLMxc" role="heading" style="margin-bottom: 10px;">
                    <div class="freebirdMaterialHeaderbannerLabelTextContainer freebirdSolidBackground">
                      <div class="freebirdMaterialHeaderbannerSectionText">Facility Information</div>
                    </div>
                    <div class="freebirdMaterialHeaderbannerSectionTriangleContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 10 10" preserveAspectRatio="none" class="freebirdMaterialHeaderbannerSectionTriangle">
                        <polygon class="freebirdSolidFill" points="0,0 10,0 0,10"></polygon>
                      </svg>
                    </div>
                  </div>

                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <input class="floating-input" type="text" placeholder=" " id="facility_name" name="facility_name" onblur="checkFacilityExist(this.value)">
                          <span class="highlight"></span>
                          <label>Facility Name <span class="mandatory">*</span></label>
                          <span id="err_facility_name" class="user_err"></span>
                        </div>
                      </div>

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" value="" onchange="setBlockDiv(this.value)" id="facility_type" name="facility_type">
                            <option value=""></option>
                            <?php foreach ($FacilityType as $key => $value) {?>
                              <option value ="<?php echo $value['id']?>" ><?php echo $value['facilityTypeName']#DH ?></option>
                            <?php } ?>
                          </select>
                          <span class="highlight"></span>
                          <label>Facility Type <span class="mandatory">*</span></label>
                          <span id="err_facility_type" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>


                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="nbcu" name="nbcu">
                            <option value=""></option>
                            <?php foreach ($NewBorn as $key => $value) {?>
                              <option value ="<?php echo $value['id']?>" ><?php echo $value['name'] ?></option>
                            <?php } ?>
                          </select>
                          <span class="highlight"></span>
                          <label>New born Care Unit Type <span class="mandatory">*</span></label>
                          <span id="err_nbcu" class="user_err"></span>
                        </div>
                      </div>


                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="govt_or_not" name="govt_or_not">
                            <option value=""></option>
                            <?php foreach ($GovtORNot as $key => $value) {?>
                              <option value ="<?php echo $value['id']; ?>" ><?php echo $value['name']; ?></option>
                            <?php } ?>
                          </select>
                          <span class="highlight"></span>
                          <label>Govt OR Non Govt </label>
                          <span id="err_govt_or_not" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>


                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">      
                          <input class="floating-input setDate" type="date" placeholder=" " id="startDate" name="startDate">
                          <span class="highlight"></span>
                          <label>KMC Lounge Start Date</label>
                          <span id="err_startDate" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>


                <div class="col-sm-12 divPadding">


                  <div class="freebirdMaterialHeaderbannerLabelContainer" jsname="bLLMxc" role="heading" style="margin-bottom: 10px;">
                    <div class="freebirdMaterialHeaderbannerLabelTextContainer freebirdSolidBackground">
                      <div class="freebirdMaterialHeaderbannerSectionText">Address Information</div>
                    </div>
                    <div class="freebirdMaterialHeaderbannerSectionTriangleContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 10 10" preserveAspectRatio="none" class="freebirdMaterialHeaderbannerSectionTriangle">
                        <polygon class="freebirdSolidFill" points="0,0 10,0 0,10"></polygon>
                      </svg>
                    </div>
                  </div>

                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" onchange="getBlockList(this.value)" id="district" name="district">
                            <option value=""></option>
                            <?php
                              foreach ($selectquery as $key => $value) {?>
                                <option value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                            <?php } ?>
                          </select>
                          <span class="highlight"></span>
                          <label>District Name <span class="mandatory">*</span></label>
                          <span id="err_district" class="user_err"></span>
                        </div>
                      </div>

                      <div class="input-field col-sm-6 col-xs-12" id="blockDiv" style="display: none;">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" name="block" id="block" onchange="getVillageList(this.value)">
                            <option value=""></option>
                          </select>
                          <span class="highlight"></span>
                          <label>Block Name <span class="mandatory">*</span></label>
                          <span id="err_block" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" name="village" id="village">
                            <option value=""></option>
                          </select>
                          <span class="highlight"></span>
                          <label>Village/Town/City Name <span class="mandatory">*</span></label>
                          <span id="err_village" class="user_err"></span>
                        </div>
                      </div>

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">      
                          <textarea class="floating-input floating-textarea" placeholder=" " name="address" id="address"></textarea>
                          <span class="highlight"></span>
                          <label>Facility Address <span class="mandatory">*</span></label>
                          <span id="err_address" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>


                <div class="col-sm-12 divPadding">

                  <div class="freebirdMaterialHeaderbannerLabelContainer" jsname="bLLMxc" role="heading" style="margin-bottom: 10px;">
                    <div class="freebirdMaterialHeaderbannerLabelTextContainer freebirdSolidBackground">
                      <div class="freebirdMaterialHeaderbannerSectionText">Admin Information</div>
                    </div>
                    <div class="freebirdMaterialHeaderbannerSectionTriangleContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 10 10" preserveAspectRatio="none" class="freebirdMaterialHeaderbannerSectionTriangle">
                        <polygon class="freebirdSolidFill" points="0,0 10,0 0,10"></polygon>
                      </svg>
                    </div>
                  </div>


                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <input class="floating-input" type="text" placeholder=" " name="moic_name" id="moic_name">
                          <span class="highlight"></span>
                          <label>CMS/MOIC Name</label>
                          <span id="err_moic_name" class="user_err"></span>
                        </div>
                      </div>

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <input class="floating-input m_b_n" type="text" maxlength="10" placeholder=" " name="moic_number" id="moic_number">
                          <span class="highlight"></span>
                          <label>CMS/MOIC Phone Number</label>
                          <span id="err_moic_number" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>
                  
                </div>

              
                <div class="input-field col-sm-12">
                  <div class="form-group">
                      <div class="col-sm-12 col-xs-12 divPadding">
                        <div class="input-field col-sm-12">
                          <div class="form-group">
                            <center><button type="submit" class="btn btn-submit btn-block btn-flat" id="submit_tab_1">Save</button></center>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>  
              </div>
              <?php echo form_close();?>
          </div>   -->
         

          <!--  +++++ Second Tab Information +++++++++ -->
          <div id="menu1" class="col-sm-12 col-xs-12 divPadding tab-pane fade in active">
              
              <?php echo form_open_multipart('RegistrationManagement/saveLounge', 'id="form-save"'); ?>

              <div class="input-field col-sm-12 col-xs-12">

                <div class="col-sm-12 col-xs-12 divPadding">

                  <div class="freebirdMaterialHeaderbannerLabelContainer" jsname="bLLMxc" role="heading" style="margin-bottom: 10px;">
                    <div class="freebirdMaterialHeaderbannerLabelTextContainer freebirdSolidBackground">
                      <div class="freebirdMaterialHeaderbannerSectionText">Lounge Information</div>
                    </div>
                    <div class="freebirdMaterialHeaderbannerSectionTriangleContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 10 10" preserveAspectRatio="none" class="freebirdMaterialHeaderbannerSectionTriangle">
                        <polygon class="freebirdSolidFill" points="0,0 10,0 0,10"></polygon>
                      </svg>
                    </div>
                  </div>

                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="district_id" name="district_id" onchange="GetFacility(this.value, 'lounge_facility')">
                            <option value=""></option>
                            <?php
                              foreach ($District as $key => $value) {?>
                                <option value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                            <?php } ?>
                          </select>
                          <span class="highlight"></span>
                          <label>District <span class="mandatory">*</span></label>
                          <span id="err_district_id" class="user_err"></span>
                        </div>
                      </div>


                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="lounge_facility" name="lounge_facility" onchange="getLounge(this.value)">
                            <option value=""></option>
                            
                          </select>
                          <span class="highlight"></span>
                          <label>Facility <span class="mandatory">*</span></label>
                          <span id="err_lounge_facility" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>


                  <div class="form-group ">
                    <div class="col-sm-12 col-xs-12 divPadding mg20">

                      <div class="input-field col-sm-6 col-xs-12">
                        <div class="floating-label">      
                          <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="lounge_id" name="lounge_id" onchange="getLastUpdate(this.value)">
                            <option value=""></option>
                            
                          </select>
                          <span class="highlight"></span>
                          <label>Lounge <span class="mandatory">*</span></label>
                          <span id="err_lounge_id" class="user_err"></span>
                        </div>
                      </div>

                    </div>
                  </div>
                  
                </div>


                <div class="col-sm-12 col-xs-12 divPadding">

                <div class="col-sm-12 col-xs-12 divPadding">
                  <div class="freebirdMaterialHeaderbannerLabelContainer" jsname="bLLMxc" role="heading" style="margin-bottom: 10px; max-width: max-content;float: left;">
                    <div class="freebirdMaterialHeaderbannerLabelTextContainer freebirdSolidBackground">
                      <div class="freebirdMaterialHeaderbannerSectionText">Lounge Amenities Details</div>
                    </div>
                    <div class="freebirdMaterialHeaderbannerSectionTriangleContainer">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 10 10" preserveAspectRatio="none" class="freebirdMaterialHeaderbannerSectionTriangle">
                        <polygon class="freebirdSolidFill" points="0,0 10,0 0,10"></polygon>
                      </svg>
                    </div>
                  </div>

                  <h5 id="last_updated" style="float: right;display: none;font-size: 16px;font-weight: 600;"></h5>

                </div>
                  
                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Bed.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Bed.png'); ?>" class="heading_icon"> 
                      </a>
                      Reclining Beds (Semi fowler beds with mattress)
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" name="bed_total_number" id="bed_total_number" onblur="checkNumberCount('bed_total_number', 'bed_functional', 'bed_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_bed_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" name="bed_functional" id="bed_functional" onblur="checkNumberCount('bed_total_number', 'bed_functional', 'bed_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_bed_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" name="bed_non_functional" id="bed_non_functional" onblur="checkNumberCount('bed_total_number', 'bed_functional', 'bed_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_bed_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>

                    


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Bed_Side_table.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Bed_Side_table.png'); ?>" class="heading_icon"> 
                      </a>
                      Bedside Table (बेड के बगल रखी जाने वाली टेबल)
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" name="table_total_number" id="table_total_number" onblur="checkNumberCount('table_total_number', 'table_functional', 'table_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_table_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" name="table_functional" id="table_functional" onblur="checkNumberCount('table_total_number', 'table_functional', 'table_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_table_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" name="table_non_functional" id="table_non_functional" onblur="checkNumberCount('table_total_number', 'table_functional', 'table_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_table_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>Colored Bedsheet & Pillow Cover (VIBGYOR)</h4>

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="bedsheet_option" value="1" id="radio-one" class="form-radio bedsheet_option" onclick="showDataDiv('1', this.value)"><label for="radio-one">Yes</label>
                      <input type="radio" name="bedsheet_option" value="2" id="radio-two" class="form-radio bedsheet_option" onclick="showDataDiv('1', this.value)"><label for="radio-two">No</label>
                      <div><span id="err_bedsheet_option" class="user_err"></span></div>
                    </div>


                    <div id="div_1_1" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mg20">

                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="bedsheet_total_number" name="bedsheet_total_number" onblur="checkNumberCount('bedsheet_total_number', 'bedsheet_functional', 'bedsheet_non_functional')">
                              <span class="highlight"></span>
                              <label>Total Numbers <span class="mandatory">*</span></label>
                              <span id="err_bedsheet_total_number" class="user_err"></span>
                            </div>
                          </div>


                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="bedsheet_functional" name="bedsheet_functional" onblur="checkNumberCount('bedsheet_total_number', 'bedsheet_functional', 'bedsheet_non_functional')">
                              <span class="highlight"></span>
                              <label>Functional <span class="mandatory">*</span></label>
                              <span id="err_bedsheet_functional" class="user_err"></span>
                            </div>
                          </div>


                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="bedsheet_non_functional" name="bedsheet_non_functional" onblur="checkNumberCount('bedsheet_total_number', 'bedsheet_functional', 'bedsheet_non_functional')">
                              <span class="highlight"></span>
                              <label>Non Functional <span class="mandatory">*</span></label>
                              <span id="err_bedsheet_non_functional" class="user_err"></span>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div id="div_1_2" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mgBT20">

                          <div class="input-field col-sm-6 col-xs-12">
                            <div class="floating-label">      
                              <textarea class="floating-input floating-textarea" placeholder=" " id="bedsheet_reason" name="bedsheet_reason"></textarea>
                              <span class="highlight"></span>
                              <label>Reason <span class="mandatory">*</span></label>
                              <span id="err_bedsheet_reason" class="user_err"></span>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Chair.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Chair.png'); ?>" class="heading_icon"> 
                      </a>
                      Reclining Chair
                    </h4>

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="chair_total_number" name="chair_total_number" onblur="checkNumberCount('chair_total_number', 'chair_functional', 'chair_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_chair_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="chair_functional" name="chair_functional" onblur="checkNumberCount('chair_total_number', 'chair_functional', 'chair_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_chair_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="chair_non_functional" name="chair_non_functional" onblur="checkNumberCount('chair_total_number', 'chair_functional', 'chair_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_chair_non_functional" class="user_err"></span>
                          </div>
                        </div>
                           
                      </div>
                    </div>

                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Tabel_Chair.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Tabel_Chair.png'); ?>" class="heading_icon">
                      </a> 
                      Chair & Table for Nurse (Nursing Station)
                    </h4>

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="nurse_table_option" value="1" id="radio-one" class="form-radio nurse_table_option" onclick="showDataDiv('2', this.value)"><label for="radio-one">Yes</label>
                      <input type="radio" name="nurse_table_option" value="2" id="radio-two" class="form-radio nurse_table_option" onclick="showDataDiv('2', this.value)"><label for="radio-two">No</label>
                      <div><span id="err_nurse_table_option" class="user_err"></span></div>
                    </div>


                    <div id="div_2_1" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mg20">

                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="nurse_table_total_number" name="nurse_table_total_number" onblur="checkNumberCount('nurse_table_total_number', 'nurse_table_functional', 'nurse_table_non_functional')">
                              <span class="highlight"></span>
                              <label>Total Numbers <span class="mandatory">*</span></label>
                              <span id="err_nurse_table_total_number" class="user_err"></span>
                            </div>
                          </div>


                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="nurse_table_functional" name="nurse_table_functional" onblur="checkNumberCount('nurse_table_total_number', 'nurse_table_functional', 'nurse_table_non_functional')">
                              <span class="highlight"></span>
                              <label>Functional <span class="mandatory">*</span></label>
                              <span id="err_nurse_table_functional" class="user_err"></span>
                            </div>
                          </div>


                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="nurse_table_non_functional" name="nurse_table_non_functional" onblur="checkNumberCount('nurse_table_total_number', 'nurse_table_functional', 'nurse_table_non_functional')">
                              <span class="highlight"></span>
                              <label>Non Functional <span class="mandatory">*</span></label>
                              <span id="err_nurse_table_non_functional" class="user_err"></span>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div id="div_2_2" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mgBT20">

                          <div class="input-field col-sm-6 col-xs-12">
                            <div class="floating-label">      
                              <textarea class="floating-input floating-textarea" placeholder=" " id="nurse_table_reason" name="nurse_table_reason"></textarea>
                              <span class="highlight"></span>
                              <label>Reason <span class="mandatory">*</span></label>
                              <span id="err_nurse_table_reason" class="user_err"></span>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/High_Table.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/High_Table.png'); ?>" class="heading_icon">
                      </a> 
                        High Stool for Weighing Scale (वजन मशीन रखने वाली ऊंची टेबल)
                    </h4>

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="highstool_option" value="1" id="radio-one" class="form-radio highstool_option" onclick="showDataDiv('3', this.value)"><label for="radio-one">Yes</label>
                      <input type="radio" name="highstool_option" value="2" id="radio-two" class="form-radio highstool_option" onclick="showDataDiv('3', this.value)"><label for="radio-two">No</label>
                      <div><span id="err_highstool_option" class="user_err"></span></div>
                    </div>


                    <div id="div_3_1" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mg20">

                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="highstool_total_number" name="highstool_total_number" onblur="checkNumberCount('highstool_total_number', 'highstool_functional', 'highstool_non_functional')">
                              <span class="highlight"></span>
                              <label>Total Numbers <span class="mandatory">*</span></label>
                              <span id="err_highstool_total_number" class="user_err"></span>
                            </div>
                          </div>


                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="highstool_functional" name="highstool_functional" onblur="checkNumberCount('highstool_total_number', 'highstool_functional', 'highstool_non_functional')">
                              <span class="highlight"></span>
                              <label>Functional <span class="mandatory">*</span></label>
                              <span id="err_highstool_functional" class="user_err"></span>
                            </div>
                          </div>


                          <div class="input-field col-sm-4 col-xs-12">
                            <div class="floating-label">
                              <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="highstool_non_functional" name="highstool_non_functional" onblur="checkNumberCount('highstool_total_number', 'highstool_functional', 'highstool_non_functional')">
                              <span class="highlight"></span>
                              <label>Non Functional <span class="mandatory">*</span></label>
                              <span id="err_highstool_non_functional" class="user_err"></span>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div id="div_3_2" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mgBT20">

                          <div class="input-field col-sm-6 col-xs-12">
                            <div class="floating-label">      
                              <textarea class="floating-input floating-textarea" placeholder=" " id="highstool_reason" name="highstool_reason"></textarea>
                              <span class="highlight"></span>
                              <label>Reason <span class="mandatory">*</span></label>
                              <span id="err_highstool_reason" class="user_err"></span>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                 

                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Cupboard.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Cupboard.png'); ?>" class="heading_icon"> 
                      </a>
                      Cupboard (अलमारी)
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="cubord_total_number" name="cubord_total_number" onblur="checkNumberCount('cubord_total_number', 'cubord_functional', 'cubord_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_cubord_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="cubord_functional" name="cubord_functional" onblur="checkNumberCount('cubord_total_number', 'cubord_functional', 'cubord_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_cubord_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="cubord_non_functional" name="cubord_non_functional" onblur="checkNumberCount('cubord_total_number', 'cubord_functional', 'cubord_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_cubord_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Air_Conditioner.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Air_Conditioner.png'); ?>" class="heading_icon"> 
                      </a>
                      Air Conditioner
                    </h4>

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="ac_total_number" name="ac_total_number" onblur="checkNumberCount('ac_total_number', 'ac_functional', 'ac_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_ac_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="ac_functional" name="ac_functional" onblur="checkNumberCount('ac_total_number', 'ac_functional', 'ac_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_ac_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="ac_non_functional" name="ac_non_functional" onblur="checkNumberCount('ac_total_number', 'ac_functional', 'ac_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_ac_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Room_Heater.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Room_Heater.png'); ?>" class="heading_icon"> 
                      </a>
                      Room Heater (Oil Filter)
                    </h4>

                     <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="room_heater_total_number" name="room_heater_total_number" onblur="checkNumberCount('room_heater_total_number', 'room_heater_functional', 'room_heater_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_room_heater_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="room_heater_functional" name="room_heater_functional" onblur="checkNumberCount('room_heater_total_number', 'room_heater_functional', 'room_heater_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_room_heater_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="room_heater_non_functional" name="room_heater_non_functional" onblur="checkNumberCount('room_heater_total_number', 'room_heater_functional', 'room_heater_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_room_heater_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>



                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Digital_Weighing.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Digital_Weighing.png'); ?>" class="heading_icon"> 
                      </a>
                      Digital Weighing Scale (वजन मापने की डिजिटल मशीन)
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="weighing_scale_total_number" name="weighing_scale_total_number" onblur="checkNumberCount('weighing_scale_total_number', 'weighing_scale_functional', 'weighing_scale_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_weighing_scale_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="weighing_scale_functional" name="weighing_scale_functional" onblur="checkNumberCount('weighing_scale_total_number', 'weighing_scale_functional', 'weighing_scale_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_weighing_scale_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="weighing_scale_non_functional" name="weighing_scale_non_functional" onblur="checkNumberCount('weighing_scale_total_number', 'weighing_scale_functional', 'weighing_scale_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_weighing_scale_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Ceiling_Fans.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Ceiling_Fans.png'); ?>" class="heading_icon">
                      </a> 
                      Fans
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="2" id="fan_total_number" name="fan_total_number" onblur="checkNumberCount('fan_total_number', 'fan_functional', 'fan_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_fan_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="2" id="fan_functional" name="fan_functional" onblur="checkNumberCount('fan_total_number', 'fan_functional', 'fan_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_fan_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="2" id="fan_non_functional" name="fan_non_functional" onblur="checkNumberCount('fan_total_number', 'fan_functional', 'fan_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_fan_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Room_thermometer_with_digital_clocks.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Room_thermometer_with_digital_clocks.png'); ?>" class="heading_icon">
                      </a> 
                        Room Thermometer With Digital Clocks
                    </h4>

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="thermometer_option" value="1" id="radio-one" class="form-radio thermometer_option" onclick="showDataDiv('4', this.value)"><label for="radio-one">Yes</label>
                      <input type="radio" name="thermometer_option" value="2" id="radio-two" class="form-radio thermometer_option" onclick="showDataDiv('4', this.value)"><label for="radio-two">No</label>
                      <div><span id="err_thermometer_option" class="user_err"></span></div>
                    </div>


                    <div id="div_4_1" style="display: none;">
                      <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="thermometer_total_number" name="thermometer_total_number" onblur="checkNumberCount('thermometer_total_number', 'thermometer_functional', 'thermometer_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_thermometer_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="thermometer_functional" name="thermometer_functional" onblur="checkNumberCount('thermometer_total_number', 'thermometer_functional', 'thermometer_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_thermometer_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="thermometer_non_functional" name="thermometer_non_functional" onblur="checkNumberCount('thermometer_total_number', 'thermometer_functional', 'thermometer_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_thermometer_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>
                    </div>

                    <div id="div_4_2" style="display: none;">
                      <div class="form-group ">
                        <div class="col-sm-12 col-xs-12 divPadding mgBT20">

                          <div class="input-field col-sm-6 col-xs-12">
                            <div class="floating-label">      
                              <textarea class="floating-input floating-textarea" placeholder=" " id="thermometer_reason" name="thermometer_reason"></textarea>
                              <span class="highlight"></span>
                              <label>Reason <span class="mandatory">*</span></label>
                              <span id="err_thermometer_reason" class="user_err"></span>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>


                    <h4>Availability Of <a href="<?php echo base_url('assets/images/amenities_icon/Mask.jpg'); ?>" class="without-caption image-link"><img src="<?php echo base_url('assets/images/amenities_icon/Mask.png'); ?>" class="heading_icon"></a> Masks, <a href="<?php echo base_url('assets/images/amenities_icon/Shoe_Cover.jpg'); ?>" class="without-caption image-link"><img src="<?php echo base_url('assets/images/amenities_icon/Shoe_Cover.png'); ?>" class="heading_icon"></a> Shoe Covers & <a href="<?php echo base_url('assets/images/amenities_icon/Slipers.jpg'); ?>" class="without-caption image-link"><img src="<?php echo base_url('assets/images/amenities_icon/Slipers.png'); ?>" class="heading_icon"></a> Slippers</h4>
                 
                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="mask_supply_option" value="1" id="radio-one" class="form-radio mask_supply_option" ><label for="radio-one">Yes</label>
                      <input type="radio" name="mask_supply_option" value="2" id="radio-two" class="form-radio mask_supply_option" ><label for="radio-two">No</label>
                      <div><span id="err_mask_supply_option" class="user_err"></span></div>
                    </div>
                    


                    <h4>Power Backup Facility in the Hospital</h4>

                    <div class="input-field col-sm-4 col-xs-6 radioCSS">
                      <input type="checkbox" name="inverter" value="1" id="check1" class="form-checkbox" ><label for="radio-one">Invertor</label>
                      <div><span id="err_power_backup_option" class="user_err"></span></div>
                    </div>

                
                    <div class="input-field col-sm-4 col-xs-6 radioCSS">
                      <input type="checkbox" name="generator" value="1" id="check2" class="form-checkbox"><label for="radio-two">Generator</label>
                    </div>

                    <div class="input-field col-sm-4 col-xs-12 radioCSS">
                      <input type="checkbox" name="solar" value="1" id="check3" class="form-checkbox"><label for="radio-two">Solar</label>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Baby_Blanket_WrapGown_Kit.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Baby_Blanket_WrapGown_Kit.png'); ?>" class="heading_icon">
                      </a>
                        Availability Of Baby Blanket/Wrap, Gown & KMC Baby Kit
                    </h4>
                 

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="babykit_supply_option" value="1" id="radio-one" class="form-radio babykit_supply_option"><label for="radio-one">Yes</label>
                      <input type="radio" name="babykit_supply_option" value="2" id="radio-two" class="form-radio babykit_supply_option"><label for="radio-two">No</label>
                      <div><span id="err_babykit_supply_option" class="user_err"></span></div>
                    </div>

                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Adult_Blankets.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Adult_Blankets.png'); ?>" class="heading_icon"> 
                      </a>
                      Availability Of Adult Blankets
                    </h4>
                 

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="blanket_supply_option" value="1" id="radio-one" class="form-radio blanket_supply_option"><label for="radio-one">Yes</label>
                      <input type="radio" name="blanket_supply_option" value="2" id="radio-two" class="form-radio blanket_supply_option"><label for="radio-two">No</label>
                      <div><span id="err_blanket_supply_option" class="user_err"></span></div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Digital_Thermometer.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Digital_Thermometer.png'); ?>" class="heading_icon">
                      </a> 
                      Digital Thermometer For Baby & Mother
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" name="digital_thermo_total_number" id="digital_thermo_total_number" onblur="checkNumberCount('digital_thermo_total_number', 'digital_thermo_functional', 'digital_thermo_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_digital_thermo_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" name="digital_thermo_functional" id="digital_thermo_functional" onblur="checkNumberCount('digital_thermo_total_number', 'digital_thermo_functional', 'digital_thermo_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_digital_thermo_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" name="digital_thermo_non_functional" id="digital_thermo_non_functional" onblur="checkNumberCount('digital_thermo_total_number', 'digital_thermo_functional', 'digital_thermo_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_digital_thermo_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Pulse_Oximeter.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Pulse_Oximeter.png'); ?>" class="heading_icon">
                      </a> 
                      Pulse Oximeter
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="oximeter_total_number" name="oximeter_total_number" onblur="checkNumberCount('oximeter_total_number', 'oximeter_functional', 'oximeter_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_oximeter_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="oximeter_functional" name="oximeter_functional" onblur="checkNumberCount('oximeter_total_number', 'oximeter_functional', 'oximeter_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_oximeter_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="oximeter_non_functional" name="oximeter_non_functional" onblur="checkNumberCount('oximeter_total_number', 'oximeter_functional', 'oximeter_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_oximeter_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Blood_Preasure_Monitor.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Blood_Preasure_Monitor.png'); ?>" class="heading_icon">
                      </a> 
                        Blood Pressure Monitor
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="bp_total_number" name="bp_total_number" onblur="checkNumberCount('bp_total_number', 'bp_functional', 'bp_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_bp_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="bp_functional" name="bp_functional" onblur="checkNumberCount('bp_total_number', 'bp_functional', 'bp_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_bp_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="1" id="bp_non_functional" name="bp_non_functional" onblur="checkNumberCount('bp_total_number', 'bp_functional', 'bp_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_bp_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Television.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Television.png'); ?>" class="heading_icon">
                      </a> 
                      Television
                    </h4>

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="tv_total_number" name="tv_total_number" onblur="checkNumberCount('tv_total_number', 'tv_functional', 'tv_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_tv_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="tv_functional" name="tv_functional" onblur="checkNumberCount('tv_total_number', 'tv_functional', 'tv_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_tv_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="tv_non_functional" name="tv_non_functional" onblur="checkNumberCount('tv_total_number', 'tv_functional', 'tv_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_tv_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>

                    <h4>
                      <a href="<?php echo base_url('assets/images/amenities_icon/Wall_Clock.jpg'); ?>" class="without-caption image-link">
                        <img src="<?php echo base_url('assets/images/amenities_icon/Wall_Clock.png'); ?>" class="heading_icon"></a> Wall Clock
                    </h4>
                 

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="clock_total_number" name="clock_total_number" onblur="checkNumberCount('clock_total_number', 'clock_functional', 'clock_non_functional')">
                            <span class="highlight"></span>
                            <label>Total Numbers <span class="mandatory">*</span></label>
                            <span id="err_clock_total_number" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="clock_functional" name="clock_functional" onblur="checkNumberCount('clock_total_number', 'clock_functional', 'clock_non_functional')">
                            <span class="highlight"></span>
                            <label>Functional <span class="mandatory">*</span></label>
                            <span id="err_clock_functional" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-4 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="4" id="clock_non_functional" name="clock_non_functional" onblur="checkNumberCount('clock_total_number', 'clock_functional', 'clock_non_functional')">
                            <span class="highlight"></span>
                            <label>Non Functional <span class="mandatory">*</span></label>
                            <span id="err_clock_non_functional" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <h4>Availability Of KMC Register</h4>
                 

                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="radio" name="kmc_register" value="1" id="radio-one" class="form-radio kmc_register"><label for="radio-one">Yes</label>
                      <input type="radio" name="kmc_register" value="2" id="radio-two" class="form-radio kmc_register"><label for="radio-two">No</label>
                      <div><span id="err_kmc_register" class="user_err"></span></div>
                    </div>


                    <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="checkbox" value="1" id="terms" class="form-checkbox" onchange="applyReadonly('terms')" ><label for="terms" id="terms-label">By signing this form I agree that all of the above statements are true and accurate.</label>
                      <span id="err_terms" class="user_err"></span>
                    </div>
                    
                  

                </div>

                <div class="input-field col-sm-12 col-xs-12">
                  <div class="form-group">
                      <div class="col-sm-12 col-xs-12 divPadding">
                        <div class="input-field col-sm-12 col-xs-12">
                          <div class="form-group">
                            <center>
                              <button type="button" class="btn btn-submit btn-block btn-flat" id="submit_tab_2" value="2">Save</button>

                              <input type="hidden" id="otp_status" value="1">
                              <input type="hidden" name="mobile_verify" id="hidden_mobile_verify">
                              
                            </center>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>  
              </div>
              <?php echo form_close(); ?>
          </div>  

          <!--  +++++ Third Tab Information +++++++++ -->
            <div id="menu2" class="col-sm-12 col-xs-12 divPadding tab-pane fade">
              
              <?php echo form_open_multipart('RegistrationManagement/saveStaff', 'id="form-staff-save"'); ?>
              
                <div class="input-field col-sm-12 col-xs-12">

                  <div class="col-sm-12 col-xs-12 divPadding">

                    <div class="freebirdMaterialHeaderbannerLabelContainer" jsname="bLLMxc" role="heading" style="margin-bottom: 10px;">
                      <div class="freebirdMaterialHeaderbannerLabelTextContainer freebirdSolidBackground">
                        <div class="freebirdMaterialHeaderbannerSectionText">Staff Information</div>
                      </div>
                      <div class="freebirdMaterialHeaderbannerSectionTriangleContainer">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 10 10" preserveAspectRatio="none" class="freebirdMaterialHeaderbannerSectionTriangle">
                          <polygon class="freebirdSolidFill" points="0,0 10,0 0,10"></polygon>
                        </svg>
                      </div>
                    </div>

                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="staff_district_id" name="staff_district_id" onchange="GetFacility(this.value, 'staff_facility')">
                              <option value=""></option>
                              <?php
                                foreach ($District as $key => $value) {?>
                                  <option value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                              <?php } ?>
                            </select>
                            <span class="highlight"></span>
                            <label>District <span class="mandatory">*</span></label>
                            <span id="err_staff_district_id" class="user_err"></span>
                          </div>
                        </div>


                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="staff_facility" name="staff_facility" >
                              <option value=""></option>
                              
                            </select>
                            <span class="highlight"></span>
                            <label>Facility <span class="mandatory">*</span></label>
                            <span id="err_staff_facility" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input" type="text" placeholder=" " id="staff_name" name="staff_name">
                            <span class="highlight"></span>
                            <label>Staff Name <span class="mandatory">*</span></label>
                            <span id="err_staff_name" class="user_err"></span>
                          </div>
                        </div>

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="10" id="mobile_number" name="mobile_number" onblur="checkStaffMobile(this.value)">
                            <span class="highlight"></span>
                            <label>Staff Mobile Number <span class="mandatory">*</span></label>
                            <span id="err_mobile_number" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                     <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text" placeholder=" " id="emergency_number" maxlength="10" name="emergency_number">
                            <span class="highlight"></span>
                            <label>Emergency Contact Number</label>
                            <span id="err_emergency_number" class="user_err"></span>
                          </div>
                        </div>

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="staff_type" name="staff_type" onchange="GetStaffSubType(this.value)">
                              <option value=""></option>
                                <?php foreach ($GetStaffType as $key => $value) { ?>
                                <option value="<?php echo $value['staffTypeId'] ?>"><?php echo $value['staffTypeNameEnglish'] ?></option>
                              <?php }  ?>
                            </select>
                            <span class="highlight"></span>
                            <label>Staff Type <span class="mandatory">*</span></label>
                            <span id="err_staff_type" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>


                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="staff_sub_type" name="staff_sub_type" onchange="openOtherStaffSubType(this);">
                              <option value=""></option>
                            </select>
                            <span class="highlight"></span>
                            <label>Staff Sub Type</label>
                            <span id="err_staff_sub_type" class="user_err"></span>
                            <input type="hidden" id="staff_sub_type_val" name="staff_sub_type_val">
                          </div>
                        </div>

                        <div class="input-field col-sm-6 col-xs-12" id="staff_sub_type_other_div" style="display:none;">
                          <div class="floating-label">
                            <input class="floating-input" type="text" id="staff_sub_type_other" name="staff_sub_type_other">
                            <span class="highlight"></span>
                            <label>Specify Other Sub Type <span class="mandatory">*</span></label>
                            <span id="err_staff_sub_type_other" class="user_err"></span>
                          </div>
                        </div>

                        <div class="input-field col-sm-6 col-xs-12" id="job_type_div1">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="job_type" name="job_type">
                              <option value=""></option>
                              <?php foreach ($GetJobType as $key => $value) { ?>
                                <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                              <?php } ?>
                            </select>
                            <span class="highlight"></span>
                            <label>Job Type </label>
                            <span id="err_job_type" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="form-group" id="job_type_div2" style="display:none;">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">
                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="job_type1" name="job_type1">
                              <option value=""></option>
                              <?php foreach ($GetJobType as $key => $value) { ?>
                                <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                              <?php } ?>
                            </select>
                            <span class="highlight"></span>
                            <label>Job Type </label>
                            <span id="err_job_type" class="user_err"></span>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input" id="fileInput" type="text" placeholder=" "  id="staff_photo">
                            <input type="file" id="staffPhoto" style="display: none;" name="staff_photo" accept="image/x-png,image/gif,image/jpeg">
                            <span class="highlight"></span>
                            <label>Staff Photo (Optional)</label>
                            <span id="err_staff_photo" class="user_err"></span>
                          </div>
                          <div id="dvPreview" style="display: none;"><img src="" id="dvPreviewImg"></div>
                        </div>

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">      
                            <input class="floating-input" type="textarea" placeholder=" " id="staff_address" name="staff_address">
                            <!-- <span class="highlight"></span> -->
                            <label>Staff Address </label>
                            <span id="err_staff_address" class="user_err"></span>
                          </div>
                        </div>

                        <!-- <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">      
                            <input class="floating-input" type="date" placeholder=" " id="staff_dob" name="staff_dob">
                            <span class="highlight"></span>
                            <label>Date Of Birth <span class="mandatory">*</span></label>
                            <span id="err_staff_dob" class="user_err"></span>
                          </div>
                        </div> -->

                        <!-- <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" name="staff_gender" id="staff_gender">
                              <option value=""></option>
                              <option value="1">Male</option>
                              <option value="2">Female</option>
                            </select>
                            <span class="highlight"></span>
                            <label>Gender <span class="mandatory">*</span></label>
                            <span id="err_staff_gender" class="user_err"></span>
                          </div>
                        </div> -->

                        
                      </div>
                    </div>

                    <!-- <div class="form-group ">
                      <div class="col-sm-12 col-xs-12 divPadding mg20">

                        <div class="input-field col-sm-6 col-xs-12">
                          <div class="floating-label">
                            <input class="floating-input m_b_n" type="text"  placeholder=" " id="staff_experiance" name="staff_experiance">
                            <span class="highlight"></span>
                            <label>Total Working Experiance (In Years)<span class="mandatory">*</span></label>
                            <span id="err_staff_experiance" class="user_err"></span>
                          </div>
                        </div>

                      </div>
                    </div> -->


                  </div>

                  <div class="input-field col-sm-12 col-xs-12 radioCSS">
                      <input type="checkbox" value="1" id="staff_terms" class="form-checkbox" onchange="applyReadonly('staff_terms')"><label for="staff_terms" id="terms-label-staff">By signing this form I agree that all of the above statements are true and accurate.</label>
                      <span id="err_staff_terms" class="user_err"></span>
                    </div>
                    <input type="hidden" id="staff_otp_status" value="1">
                    <input type="hidden" name="mobile_verify_staff" id="hidden_mobile_verify_staff">

                  <!-- <div id="check_div_staff" style="display: none;">
                    <div class="input-field col-sm-offset-2 col-sm-8 col-xs-10" id="mobile_verify_div_staff">
                      <div class="floating-label col-sm-10">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="10" id="mobile_verify_staff" name="mobile_verify_staff" onchange="sendOTPStaff(this.value)">
                            <span class="highlight"></span>
                            <label style="left: 15px;">Verify Mobile Number </label>
                            <span id="err_mobile_verify_staff" class="user_err"></span>
                      </div>
                    </div>

                    <div class="input-field col-sm-offset-2 col-sm-8 col-xs-10" id="otp_div_staff" style="display: none;">
                      <div class="floating-label col-sm-6">
                            <input class="floating-input m_b_n" type="text" placeholder=" " maxlength="6" id="otp_staff" name="otp_staff" onblur="removeDisableStaff(this.value)">
                            <input type="hidden" id="otpIdStaff" value="">
                            
                            <span class="highlight"></span>
                            <label style="left: 15px;">Enter OTP </label>
                            <span id="err_otp_staff" class="user_err"></span>
                            <span style="color:red;" id="countdownStaff" class="timer"></span>
                      </div>

                      <div class="col-sm-4">
                        <span id="otp_button_staff">
                          <input type="button" id="sendStaff" onclick="verifyOTPStaff()" class="btn btn-sm freebirdSolidBackground send_otp" value="Verify OTP">
                        </span>
                      </div>
                    </div>
                  </div> -->

                  <div class="input-field col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12 divPadding">
                          <div class="input-field col-sm-12 col-xs-12">
                            <div class="form-group">
                              <center><button type="button" class="btn btn-submit btn-block btn-flat" id="submit_tab_3" value="1">Save</button></center>
                            </div>
                          </div>
                        </div>

                    </div>
                  </div>  
                  
                </div>
               
              <?php echo form_close(); ?>
            </div>
          

          
            
          </div>
        </div>
        <p class="clearfix mb-0" style="text-align: center;"><span class="float-left d-inline-block">Copyright &copy; <?php echo date('Y'); ?>-<?php echo (date('Y')+1); ?> <?php echo PROJECT_NAME; ?>. All rights reserved.</span>
        </p>
      </div>
    </div>



    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12">&nbsp;</div>



<!--Modal: modalPush-->
    <div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content text-center">
          <!--Header-->
          <div class="modal-header d-flex justify-content-center" style="background-color: #00bcd4;">
            <p class="heading" style="margin-bottom: 0px;">MOBILE NUMBER VERIFICATION</p>
          </div>

          <!--Body-->
          <div class="modal-body" style="background-color: #fff!important; color: #000!important;height: 150px;">

            <p style="font-size: 18px;">Please verify your mobile number to submit form</p>

            <div class="col-sm-12 col-xs-12" style="margin-top: 15px;">
              <div class="floating-label col-sm-9">
                  <input class="floating-input m_b_n" type="text" placeholder="MOBILE NUMBER" maxlength="10" id="mobile_verify" onchange="enableButton(this.value, 'err_mobile_verify')" style="font-size: 14px; color: #575B5F;">
                  <span class="highlight"></span>
                  
                  <span id="err_mobile_verify" class="user_err" style="float: left;"></span>
              </div>
              <div class="col-sm-3" style="padding-left: 5px;">
                <span id="send_otp_button">
                  <input type="button" id="send_otp" onclick="sendOTP()" class="btn btn-sm send_otp" value="Get OTP" style="background-color: #00bcd4;">
                </span>
              </div>
            </div>

          </div>

          <div class="modal-footer">
                <input type="button" id="btnClosePopup" value="Close" class="btn btn-danger" />
            </div>
        </div>
        <!--/.Content-->
      </div>
    </div>
<!--Modal: modalPush-->

<!--Modal: modalPush-->
    <div class="modal fade" id="modalPushOtp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content text-center">
          <!--Header-->
          <div class="modal-header d-flex justify-content-center" style="background-color: #00bcd4;">
            <p class="heading" style="margin-bottom: 0px;">MOBILE NUMBER VERIFICATION</p>
          </div>

          <!--Body-->
          <div class="modal-body" id="success-modal" style="background-color: #fff!important; color: #000!important;height: 150px;">

            <p style="font-size: 18px;">Please enter the OTP sent at <span id="mobile_span"></span></p>

            <div class="col-sm-12 col-xs-12" style="margin-top: 15px;">
              <div class="floating-label col-sm-7" style="margin-left: 20px;">
                  <input class="floating-input m_b_n" type="text" placeholder="ENTER OTP" maxlength="6" id="otp" name="otp" onblur="removeDisable(this.value)" style="font-size: 14px; color: #575B5F;">
                  <input type="hidden" id="otpId" value="">
                  
                  <span class="highlight"></span>
                  <span style="color:red;float: left;width: 100%;text-align: left;" id="countdown" class="timer"></span>
                  <span id="err_otp" class="user_err" style="float: left;width: 100%;text-align: left;"></span>
                  
              </div>
              <div class="col-sm-3" style="padding-left: 5px;">
                <span id="otp_button">
                  <input type="button" id="send" onclick="verifyOTP()" class="btn btn-sm send_otp" value="Verify OTP" style="background-color: #00bcd4;">
                </span>
              </div>
            </div>

          </div>

          
        </div>
        <!--/.Content-->
      </div>
    </div>
<!--Modal: modalPush-->


<!--Modal: modalPush-->
    <div class="modal fade" id="modalPushStaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content text-center">
          <!--Header-->
          <div class="modal-header d-flex justify-content-center" style="background-color: #00bcd4;">
            <p class="heading" style="margin-bottom: 0px;">MOBILE NUMBER VERIFICATION</p>
          </div>

          <!--Body-->
          <div class="modal-body" style="background-color: #fff!important; color: #000!important;height: 150px;">

            <p style="font-size: 18px;">Please verify your mobile number to submit form</p>

            <div class="col-sm-12 col-xs-12" style="margin-top: 15px;">
              <div class="floating-label col-sm-9">
                  <input class="floating-input m_b_n" type="text" placeholder="MOBILE NUMBER" maxlength="10" id="mobile_verify_staff" onchange="enableButton(this.value, 'err_mobile_verify_staff')" style="font-size: 14px; color: #575B5F;">
                  <span class="highlight"></span>
                  
                  <span id="err_mobile_verify_staff" class="user_err" style="float: left;"></span>
              </div>
              <div class="col-sm-3" style="padding-left: 5px;">
                <span id="send_otp_staff_button">
                  <input type="button" id="send_otp_staff" onclick="sendOTPStaff()" class="btn btn-sm send_otp" value="Get OTP" style="background-color: #00bcd4;">
                </span>
              </div>
            </div>

          </div>
<div class="modal-footer">
                <input type="button" id="btnCloseStaffPopup" value="Close" class="btn btn-danger" />
            </div>
          
        </div>
        <!--/.Content-->
      </div>
    </div>
<!--Modal: modalPush-->

<!--Modal: modalPush-->
    <div class="modal fade" id="modalPushOtpStaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content text-center">
          <!--Header-->
          <div class="modal-header d-flex justify-content-center" style="background-color: #00bcd4;">
            <p class="heading" style="margin-bottom: 0px;">MOBILE NUMBER VERIFICATION</p>
          </div>

          <!--Body-->
          <div class="modal-body" id="success-modal-staff" style="background-color: #fff!important; color: #000!important;height: 150px;">

            <p style="font-size: 18px;">Please enter the OTP sent at <span id="mobile_span_staff"></span></p>

            <div class="col-sm-12 col-xs-12" style="margin-top: 15px;">
              <div class="floating-label col-sm-7" style="margin-left: 20px;">
                  <input class="floating-input m_b_n" type="text" placeholder="ENTER OTP" maxlength="6" id="otp_staff" name="otp_staff" onblur="removeDisableStaff(this.value)" style="font-size: 14px; color: #575B5F;">
                  <input type="hidden" id="otpIdStaff" value="">
                  
                  <span class="highlight"></span>
                  <span style="color:red;float: left;width: 100%;text-align: left;" id="countdownStaff" class="timer"></span>
                  <span id="err_otp_staff" class="user_err" style="float: left;width: 100%;text-align: left;"></span>
                  
              </div>
              <div class="col-sm-3" style="padding-left: 5px;">
                <span id="otp_button_staff">
                  <input type="button" id="sendStaff" onclick="verifyOTPStaff()" class="btn btn-sm send_otp" value="Verify OTP" style="background-color: #00bcd4;" >
                </span>
              </div>
            </div>

          </div>

          
        </div>
        <!--/.Content-->
      </div>
    </div>
<!--Modal: modalPush-->
    
  </body>
</html>



<!-- <script src="<?php //echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script> -->
<!-- Bootstrap 3.3.7 -->
<!-- <script src="<?php // echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- iCheck -->
 <script src="<?php echo base_url(); ?>assets/admin/plugins/iCheck/icheck.min.js"></script>
 
 <script>

  var countdownTimer = '';
  var seconds = 0;

  var countdownTimer2 = '';
  var seconds2 = 0;

  function secondPassed2() {
       
      var minutes2 = Math.round((seconds2 - 30)/60);
      var remainingSeconds2 = seconds2 % 60;
      var href2 = '00:00';
      if (remainingSeconds2 < 10) {
         remainingSeconds2 = "0" + remainingSeconds2;  
      }
      document.getElementById('countdownStaff').innerHTML = "0"+minutes2 + ":" + remainingSeconds2;
      if (seconds2 == 0) {
          clearInterval(countdownTimer2);
          document.getElementById('countdownStaff').innerHTML = href2;
          countdownTimer2 = '';
          openResend2();
      } else {
          seconds2--;
      }
      //Event.preventDefault();
  }


  function secondPassed() {
       
      var minutes = Math.round((seconds - 30)/60);
      var remainingSeconds = seconds % 60;
      var href = '00:00';
      if (remainingSeconds < 10) {
         remainingSeconds = "0" + remainingSeconds;  
      }
      document.getElementById('countdown').innerHTML = "0"+minutes + ":" + remainingSeconds;
      if (seconds == 0) {
          clearInterval(countdownTimer);
          document.getElementById('countdown').innerHTML = href;
          countdownTimer = '';
          openResend();
      } else {
          seconds--;
      }
      //Event.preventDefault();
  }

  function openResend() {
      // $('#send').prop('disabled', false);
      $('#countdown').html('');
      $('#countdown').hide();
      var href = '<input type="button" id="send" onclick="resendSms()" class="btn btn-sm btn-danger send_otp" value="Resend OTP">';
      $('#err_otp').html('').hide();
      document.getElementById('otp_button').innerHTML = href;
  }

  function openResend2() {
      $('#countdownStaff').html('');
      $('#countdownStaff').hide();
      var href = '<input type="button" id="send" onclick="resendSmsStaff()" class="btn btn-sm btn-danger send_otp" value="Resend OTP">';
      document.getElementById('otp_button_staff').innerHTML = href;
  }

  $('select').on('change', function() {
    this.setAttribute('value', this.value);
  });


  function GetFacility(district_id, id){
    url = '<?php echo base_url('RegistrationManagement/getFacility/') ?>'; 
    facility = '';
    $.ajax({
        url: url,
        type: 'POST',
        data: {'districtId': district_id, 'facility': facility},
        success: function(result) {
          $("#"+id).html(result);
        }
    });
  }


  function getLounge(facility_id){ 
    url = '<?php echo base_url('RegistrationManagement/getLounge/') ?>'; 
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {'facility_id': facility_id},
        success: function(result) {
          $("#lounge_id").html(result);
        }
    });
  }


  function checkNumberCount(id1, id2, id3){
    var val1 = $('#'+id1).val();
    var val2 = $('#'+id2).val();
    var val3 = $('#'+id3).val();
    if(val1 != '' && val2 != '' && val3 != ''){
      if(parseInt(val1) != parseInt(val2)+parseInt(val3)){
        $('#err_'+id1).html('Total numbers must be equal to sum of functional & non functional.').show();
        
        return false;
      } else {
        $('#err_'+id1).html('').hide();
      }
    }
  }


  function getLastUpdate(lounge_id){
    url = '<?php echo base_url('RegistrationManagement/getLastUpdate/') ?>'; 
    var facility_id = $('#lounge_facility').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {'lounge_id': lounge_id, 'facility_id':facility_id},
        dataType: 'json',
        success: function(result) {
          if(result.result2 != ''){
            if(result.result1 != 0){
              $("#last_updated").html(result.result2).show();
            } else {
              $("#last_updated").html(result.result2).show();
            }
          } else {
            $("#last_updated").html('').hide();
          }

          if(result.result1 == 1){
            $('#submit_tab_2').show();
          } else {
            $('#submit_tab_2').hide();
          }
        }
    });
  }

  
  function setBlockDiv(val){
    if(val == 3){
      $('#blockDiv').show(); 
    } else {
      $('#blockDiv').hide(); 
    }
  }
 
  if($('[type="date"]').prop('type') != 'date') {
    $('[type="date"]').datepicker();
  }  

  $('#submit_tab_1').click(function(){ 
    var facility_name = $('#facility_name').val();
    if(facility_name == ''){
      $('#err_facility_name').html('This field is required.').show();
      $('#facility_name').focus();
      return false;
    } else {
      var chk_err = $('#err_facility_name').html();
      if(chk_err.length >= 5){
        $('#facility_name').focus();
        return false;
      } else {
        $('#err_facility_name').html('').hide();
      }
    }

    

    var facility_type = $('#facility_type').val();
    if(facility_type == ''){
      $('#err_facility_type').html('This field is required.').show();
      $('#facility_type').focus();
      return false;
    } else {
      $('#err_facility_type').html('').hide();
    }

    var nbcu = $('#nbcu').val();
    if(nbcu == ''){
      $('#err_nbcu').html('This field is required.').show();
      $('#nbcu').focus();
      return false;
    } else {
      $('#err_nbcu').html('').hide();
    }

    var district = $('#district').val();
    if(district == ''){
      $('#err_district').html('This field is required.').show();
      $('#district').focus();
      return false;
    } else {
      $('#err_district').html('').hide();
    }

    if(facility_type == 3){
      var block = $('#block').val();
      if(block == ''){
        $('#err_block').html('This field is required.').show();
        $('#block').focus();
        return false;
      } else {
        $('#err_block').html('').hide();
      }
    }

    var village = $('#village').val();
    if(village == ''){
      $('#err_village').html('This field is required.').show();
      $('#village').focus();
      return false;
    } else {
      $('#err_village').html('').hide();
    }

    var address = $('#address').val();
    if(address == ''){
      $('#err_address').html('This field is required.').show();
      $('#address').focus();
      return false;
    } else {
      $('#err_address').html('').hide();
    }

    var moic_number = $('#moic_number').val();
    if(moic_number != '' && moic_number.length < 10 && (moic_number.charAt(0) != 9) && (moic_number.charAt(0) != 8) && (moic_number.charAt(0) != 7) && (moic_number.charAt(0) != 6)){
      $('#err_moic_number').html('Please enter valid CMS/MOIC Phone Number.').show();
      $('#moic_number').focus();
      return false;
    } else {
      $('#err_moic_number').html('').hide();
    }


  });


  $('#submit_tab_2').click(function(event){
    //debugger;
 // event.preventDefault(); 
//return false;
    var district_id = $('#district_id').val();
    if(district_id == '' || district_id == '0'){
      $('#err_district_id').html('This field is required.').show();
      $('#district_id').focus();
      return false;
    } else {
      $('#err_district_id').html('').hide();
    }

    var lounge_facility = $('#lounge_facility').val();
    if(lounge_facility == '' || lounge_facility == '0'){
      $('#err_lounge_facility').html('This field is required.').show();
      $('#lounge_facility').focus();
      return false;
    } else {
      $('#err_lounge_facility').html('').hide();
    }

    var lounge_id = $('#lounge_id').val();
    if(lounge_id == '' || lounge_id == '0'){
      $('#err_lounge_id').html('This field is required.').show();
      $('#lounge_id').focus();
      return false;
    } else {
      $('#err_lounge_id').html('').hide();
    }


    var bed_total_number = $('#bed_total_number').val();
    if(bed_total_number == ''){
      $('#err_bed_total_number').html('This field is required.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
    }


    var bed_functional = $('#bed_functional').val();
    if(bed_functional == ''){
      $('#err_bed_functional').html('This field is required.').show();
      $('#bed_functional').focus();
      return false;
    } else {
      $('#err_bed_functional').html('').hide();
    }

    var bed_non_functional = $('#bed_non_functional').val();
    if(bed_non_functional == ''){
      $('#err_bed_non_functional').html('This field is required.').show();
      $('#bed_non_functional').focus();
      return false;
    } else {
      $('#err_bed_non_functional').html('').hide();
    }

    if(parseInt(bed_total_number) != parseInt(bed_functional)+parseInt(bed_non_functional)){
      $('#err_bed_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
    }

    var table_total_number = $('#table_total_number').val();
    if(table_total_number == ''){
      $('#err_table_total_number').html('This field is required.').show();
      $('#table_total_number').focus();
      return false;
    } else {
      $('#err_table_total_number').html('').hide();
    }


    var table_functional = $('#table_functional').val();
    if(table_functional == ''){
      $('#err_table_functional').html('This field is required.').show();
      $('#table_functional').focus();
      return false;
    } else {
      $('#err_table_functional').html('').hide();
    }

    var table_non_functional = $('#table_non_functional').val();
    if(table_non_functional == ''){
      $('#err_table_non_functional').html('This field is required.').show();
      $('#table_non_functional').focus();
      return false;
    } else {
      $('#err_table_non_functional').html('').hide();
    }

    if(parseInt(table_total_number) != parseInt(table_functional)+parseInt(table_non_functional)){
      $('#err_table_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#table_total_number').focus();
      return false;
    } else {
      $('#err_table_total_number').html('').hide();
    }

    if($('.bedsheet_option').is(':checked')){
      $('#err_bedsheet_option').html('').hide();
      var bedsheet_option = $('input[name="bedsheet_option"]:checked').val(); 
      if(bedsheet_option == 1){
        var bedsheet_total_number = $('#bedsheet_total_number').val();
        if(bedsheet_total_number == ''){
          $('#err_bedsheet_total_number').html('This field is required.').show();
          $('#bedsheet_total_number').focus();
          return false;
        } else {
          $('#err_bedsheet_total_number').html('').hide();
        }


        var bedsheet_functional = $('#bedsheet_functional').val();
        if(bedsheet_functional == ''){
          $('#err_bedsheet_functional').html('This field is required.').show();
          $('#bedsheet_functional').focus();
          return false;
        } else {
          $('#err_bedsheet_functional').html('').hide();
        }

        var bedsheet_non_functional = $('#bedsheet_non_functional').val();
        if(bedsheet_non_functional == ''){
          $('#err_bedsheet_non_functional').html('This field is required.').show();
          $('#bedsheet_non_functional').focus();
          return false;
        } else {
          $('#err_bedsheet_non_functional').html('').hide();
        }

        if(parseInt(bedsheet_total_number) != parseInt(bedsheet_functional)+parseInt(bedsheet_non_functional)){
          $('#err_bedsheet_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#bedsheet_total_number').focus();
          return false;
        } else {
          $('#err_bedsheet_total_number').html('').hide();
        }

      } else {
        var bedsheet_reason = $('#bedsheet_reason').val();
        if(bedsheet_reason == ''){
          $('#err_bedsheet_reason').html('This field is required.').show();
          $('#bedsheet_reason').focus();
          return false;
        } else {
          $('#err_bedsheet_reason').html('').hide();
        }
      }
    } else {
      $('#err_bedsheet_option').html('This field is required.').show();
      $('.bedsheet_option').focus();
      return false;
    }

    var chair_total_number = $('#chair_total_number').val();
    if(chair_total_number == ''){
      $('#err_chair_total_number').html('This field is required.').show();
      $('#chair_total_number').focus();
      return false;
    } else {
      $('#err_chair_total_number').html('').hide();
    }


    var chair_functional = $('#chair_functional').val();
    if(chair_functional == ''){
      $('#err_chair_functional').html('This field is required.').show();
      $('#chair_functional').focus();
      return false;
    } else {
      $('#err_chair_functional').html('').hide();
    }

    var chair_non_functional = $('#chair_non_functional').val();
    if(chair_non_functional == ''){
      $('#err_chair_non_functional').html('This field is required.').show();
      $('#chair_non_functional').focus();
      return false;
    } else {
      $('#err_chair_non_functional').html('').hide();
    }

    if(parseInt(chair_total_number) != parseInt(chair_functional)+parseInt(chair_non_functional)){
      $('#err_chair_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#chair_total_number').focus();
      return false;
    } else {
      $('#err_chair_total_number').html('').hide();
    }

    if($('.nurse_table_option').is(':checked')){
      $('#err_nurse_table_option').html('').hide();
      var nurse_table_option = $('input[name="nurse_table_option"]:checked').val(); 
      if(nurse_table_option == 1){
        var nurse_table_total_number = $('#nurse_table_total_number').val();
        if(nurse_table_total_number == ''){
          $('#err_nurse_table_total_number').html('This field is required.').show();
          $('#nurse_table_total_number').focus();
          return false;
        } else {
          $('#err_nurse_table_total_number').html('').hide();
        }


        var nurse_table_functional = $('#nurse_table_functional').val();
        if(nurse_table_functional == ''){
          $('#err_nurse_table_functional').html('This field is required.').show();
          $('#nurse_table_functional').focus();
          return false;
        } else {
          $('#err_nurse_table_functional').html('').hide();
        }

        var nurse_table_non_functional = $('#nurse_table_non_functional').val();
        if(nurse_table_non_functional == ''){
          $('#err_nurse_table_non_functional').html('This field is required.').show();
          $('#nurse_table_non_functional').focus();
          return false;
        } else {
          $('#err_nurse_table_non_functional').html('').hide();
        }

        if(parseInt(nurse_table_total_number) != parseInt(nurse_table_functional)+parseInt(nurse_table_non_functional)){
          $('#err_nurse_table_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#nurse_table_total_number').focus();
          return false;
        } else {
          $('#err_nurse_table_total_number').html('').hide();
        }

      } else {
        var nurse_table_reason = $('#nurse_table_reason').val();
        if(nurse_table_reason == ''){
          $('#err_nurse_table_reason').html('This field is required.').show();
          $('#nurse_table_reason').focus();
          return false;
        } else {
          $('#err_nurse_table_reason').html('').hide();
        }
      }
    } else {
      $('#err_nurse_table_option').html('This field is required.').show();
      $('.nurse_table_option').focus();
      return false;
    }

    if($('.highstool_option').is(':checked')){
      $('#err_highstool_option').html('').hide();
      var highstool_option = $('input[name="highstool_option"]:checked').val(); 
      if(highstool_option == 1){
        var highstool_total_number = $('#highstool_total_number').val();
        if(highstool_total_number == ''){
          $('#err_highstool_total_number').html('This field is required.').show();
          $('#highstool_total_number').focus();
          return false;
        } else {
          $('#err_highstool_total_number').html('').hide();
        }


        var highstool_functional = $('#highstool_functional').val();
        if(highstool_functional == ''){
          $('#err_highstool_functional').html('This field is required.').show();
          $('#highstool_functional').focus();
          return false;
        } else {
          $('#err_highstool_functional').html('').hide();
        }

        var highstool_non_functional = $('#highstool_non_functional').val();
        if(highstool_non_functional == ''){
          $('#err_highstool_non_functional').html('This field is required.').show();
          $('#highstool_non_functional').focus();
          return false;
        } else {
          $('#err_highstool_non_functional').html('').hide();
        }

        if(parseInt(highstool_total_number) != parseInt(highstool_functional)+parseInt(highstool_non_functional)){
          $('#err_highstool_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#highstool_total_number').focus();
          return false;
        } else {
          $('#err_highstool_total_number').html('').hide();
        }

      } else {
        var highstool_reason = $('#highstool_reason').val();
        if(highstool_reason == ''){
          $('#err_highstool_reason').html('This field is required.').show();
          $('#highstool_reason').focus();
          return false;
        } else {
          $('#err_highstool_reason').html('').hide();
        }
      }
    } else {
      $('#err_highstool_option').html('This field is required.').show();
      $('.highstool_option').focus();
      return false;
    }

    var cubord_total_number = $('#cubord_total_number').val();
    if(cubord_total_number == ''){
      $('#err_cubord_total_number').html('This field is required.').show();
      $('#cubord_total_number').focus();
      return false;
    } else {
      $('#err_cubord_total_number').html('').hide();
    }


    var cubord_functional = $('#cubord_functional').val();
    if(cubord_functional == ''){
      $('#err_cubord_functional').html('This field is required.').show();
      $('#cubord_functional').focus();
      return false;
    } else {
      $('#err_cubord_functional').html('').hide();
    }

    var cubord_non_functional = $('#cubord_non_functional').val();
    if(cubord_non_functional == ''){
      $('#err_cubord_non_functional').html('This field is required.').show();
      $('#cubord_non_functional').focus();
      return false;
    } else {
      $('#err_cubord_non_functional').html('').hide();
    }

    if(parseInt(cubord_total_number) != parseInt(cubord_functional)+parseInt(cubord_non_functional)){
      $('#err_cubord_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#cubord_total_number').focus();
      return false;
    } else {
      $('#err_cubord_total_number').html('').hide();
    }

    var ac_total_number = $('#ac_total_number').val();
    if(ac_total_number == ''){
      $('#err_ac_total_number').html('This field is required.').show();
      $('#ac_total_number').focus();
      return false;
    } else {
      $('#err_ac_total_number').html('').hide();
    }


    var ac_functional = $('#ac_functional').val();
    if(ac_functional == ''){
      $('#err_ac_functional').html('This field is required.').show();
      $('#ac_functional').focus();
      return false;
    } else {
      $('#err_ac_functional').html('').hide();
    }

    var ac_non_functional = $('#ac_non_functional').val();
    if(ac_non_functional == ''){
      $('#err_ac_non_functional').html('This field is required.').show();
      $('#ac_non_functional').focus();
      return false;
    } else {
      $('#err_ac_non_functional').html('').hide();
    }

    if(parseInt(ac_total_number) != parseInt(ac_functional)+parseInt(ac_non_functional)){
      $('#err_ac_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#ac_total_number').focus();
      return false;
    } else {
      $('#err_ac_total_number').html('').hide();
    }

    var room_heater_total_number = $('#room_heater_total_number').val();
    if(room_heater_total_number == ''){
      $('#err_room_heater_total_number').html('This field is required.').show();
      $('#room_heater_total_number').focus();
      return false;
    } else {
      $('#err_room_heater_total_number').html('').hide();
    }


    var room_heater_functional = $('#room_heater_functional').val();
    if(room_heater_functional == ''){
      $('#err_room_heater_functional').html('This field is required.').show();
      $('#room_heater_functional').focus();
      return false;
    } else {
      $('#err_room_heater_functional').html('').hide();
    }

    var room_heater_non_functional = $('#room_heater_non_functional').val();
    if(room_heater_non_functional == ''){
      $('#err_room_heater_non_functional').html('This field is required.').show();
      $('#room_heater_non_functional').focus();
      return false;
    } else {
      $('#err_room_heater_non_functional').html('').hide();
    }

    if(parseInt(room_heater_total_number) != parseInt(room_heater_functional)+parseInt(room_heater_non_functional)){
      $('#err_room_heater_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#room_heater_total_number').focus();
      return false;
    } else {
      $('#err_room_heater_total_number').html('').hide();
    }

    var weighing_scale_total_number = $('#weighing_scale_total_number').val();
    if(weighing_scale_total_number == ''){
      $('#err_weighing_scale_total_number').html('This field is required.').show();
      $('#weighing_scale_total_number').focus();
      return false;
    } else {
      $('#err_weighing_scale_total_number').html('').hide();
    }


    var weighing_scale_functional = $('#weighing_scale_functional').val();
    if(weighing_scale_functional == ''){
      $('#err_weighing_scale_functional').html('This field is required.').show();
      $('#weighing_scale_functional').focus();
      return false;
    } else {
      $('#err_weighing_scale_functional').html('').hide();
    }

    var weighing_scale_non_functional = $('#weighing_scale_non_functional').val();
    if(weighing_scale_non_functional == ''){
      $('#err_weighing_scale_non_functional').html('This field is required.').show();
      $('#weighing_scale_non_functional').focus();
      return false;
    } else {
      $('#err_weighing_scale_non_functional').html('').hide();
    }

    if(parseInt(weighing_scale_total_number) != parseInt(weighing_scale_functional)+parseInt(weighing_scale_non_functional)){
      $('#err_weighing_scale_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#weighing_scale_total_number').focus();
      return false;
    } else {
      $('#err_weighing_scale_total_number').html('').hide();
    }

    var fan_total_number = $('#fan_total_number').val();
    if(fan_total_number == ''){
      $('#err_fan_total_number').html('This field is required.').show();
      $('#fan_total_number').focus();
      return false;
    } else {
      $('#err_fan_total_number').html('').hide();
    }


    var fan_functional = $('#fan_functional').val();
    if(fan_functional == ''){
      $('#err_fan_functional').html('This field is required.').show();
      $('#fan_functional').focus();
      return false;
    } else {
      $('#err_fan_functional').html('').hide();
    }

    var fan_non_functional = $('#fan_non_functional').val();
    if(fan_non_functional == ''){
      $('#err_fan_non_functional').html('This field is required.').show();
      $('#fan_non_functional').focus();
      return false;
    } else {
      $('#err_fan_non_functional').html('').hide();
    }

    if(parseInt(fan_total_number) != parseInt(fan_functional)+parseInt(fan_non_functional)){
      $('#err_fan_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#fan_total_number').focus();
      return false;
    } else {
      $('#err_fan_total_number').html('').hide();
    }

    if($('.thermometer_option').is(':checked')){
      $('#err_thermometer_option').html('').hide();
      var thermometer_option = $('input[name="thermometer_option"]:checked').val(); 
      if(thermometer_option == 1){
        var thermometer_total_number = $('#thermometer_total_number').val();
        if(thermometer_total_number == ''){
          $('#err_thermometer_total_number').html('This field is required.').show();
          $('#thermometer_total_number').focus();
          return false;
        } else {
          $('#err_thermometer_total_number').html('').hide();
        }


        var thermometer_functional = $('#thermometer_functional').val();
        if(thermometer_functional == ''){
          $('#err_thermometer_functional').html('This field is required.').show();
          $('#thermometer_functional').focus();
          return false;
        } else {
          $('#err_thermometer_functional').html('').hide();
        }

        var thermometer_non_functional = $('#thermometer_non_functional').val();
        if(thermometer_non_functional == ''){
          $('#err_thermometer_non_functional').html('This field is required.').show();
          $('#thermometer_non_functional').focus();
          return false;
        } else {
          $('#err_thermometer_non_functional').html('').hide();
        }

        if(parseInt(thermometer_total_number) != parseInt(thermometer_functional)+parseInt(thermometer_non_functional)){
          $('#err_thermometer_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#thermometer_total_number').focus();
          return false;
        } else {
          $('#err_thermometer_total_number').html('').hide();
        }

      } else {
        var thermometer_reason = $('#thermometer_reason').val();
        if(thermometer_reason == ''){
          $('#err_thermometer_reason').html('This field is required.').show();
          $('#thermometer_reason').focus();
          return false;
        } else {
          $('#err_thermometer_reason').html('').hide();
        }
      }
    } else {
      $('#err_thermometer_option').html('This field is required.').show();
      $('.thermometer_option').focus();
      return false;
    }

    if($('.mask_supply_option').is(':checked')){
      $('#err_mask_supply_option').html('').hide();
    } else {
      $('#err_mask_supply_option').html('This field is required.').show();
      $('.mask_supply_option').focus();
      return false;
    }

    if ($(".form-checkbox:checked").length > 0){
      $('#err_power_backup_option').html('').hide();
    } else {
      $('#err_power_backup_option').html('This field is required.').show();
      $('.form-checkbox').focus();
      return false;
    }

    if($('.babykit_supply_option').is(':checked')){
      $('#err_babykit_supply_option').html('').hide();
    } else {
      $('#err_babykit_supply_option').html('This field is required.').show();
      $('.babykit_supply_option').focus();
      return false;
    }

    if($('.blanket_supply_option').is(':checked')){
      $('#err_blanket_supply_option').html('').hide();
    } else {
      $('#err_blanket_supply_option').html('This field is required.').show();
      $('.blanket_supply_option').focus();
      return false;
    }

    var digital_thermo_total_number = $('#digital_thermo_total_number').val();
    if(digital_thermo_total_number == ''){
      $('#err_digital_thermo_total_number').html('This field is required.').show();
      $('#digital_thermo_total_number').focus();
      return false;
    } else {
      $('#err_digital_thermo_total_number').html('').hide();
    }


    var digital_thermo_functional = $('#digital_thermo_functional').val();
    if(digital_thermo_functional == ''){
      $('#err_digital_thermo_functional').html('This field is required.').show();
      $('#digital_thermo_functional').focus();
      return false;
    } else {
      $('#err_digital_thermo_functional').html('').hide();
    }

    var digital_thermo_non_functional = $('#digital_thermo_non_functional').val();
    if(digital_thermo_non_functional == ''){
      $('#err_digital_thermo_non_functional').html('This field is required.').show();
      $('#digital_thermo_non_functional').focus();
      return false;
    } else {
      $('#err_digital_thermo_non_functional').html('').hide();
    }

    if(parseInt(digital_thermo_total_number) != parseInt(digital_thermo_functional)+parseInt(digital_thermo_non_functional)){
      $('#err_digital_thermo_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#digital_thermo_total_number').focus();
      return false;
    } else {
      $('#err_digital_thermo_total_number').html('').hide();
    }


    var oximeter_total_number = $('#oximeter_total_number').val();
    if(oximeter_total_number == ''){
      $('#err_oximeter_total_number').html('This field is required.').show();
      $('#oximeter_total_number').focus();
      return false;
    } else {
      $('#err_oximeter_total_number').html('').hide();
    }


    var oximeter_functional = $('#oximeter_functional').val();
    if(oximeter_functional == ''){
      $('#err_oximeter_functional').html('This field is required.').show();
      $('#oximeter_functional').focus();
      return false;
    } else {
      $('#err_oximeter_functional').html('').hide();
    }

    var oximeter_non_functional = $('#oximeter_non_functional').val();
    if(oximeter_non_functional == ''){
      $('#err_oximeter_non_functional').html('This field is required.').show();
      $('#oximeter_non_functional').focus();
      return false;
    } else {
      $('#err_oximeter_non_functional').html('').hide();
    }

    if(parseInt(oximeter_total_number) != parseInt(oximeter_functional)+parseInt(oximeter_non_functional)){
      $('#err_oximeter_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#oximeter_total_number').focus();
      return false;
    } else {
      $('#err_oximeter_total_number').html('').hide();
    }

    var bp_total_number = $('#bp_total_number').val();
    if(bp_total_number == ''){
      $('#err_bp_total_number').html('This field is required.').show();
      $('#bp_total_number').focus();
      return false;
    } else {
      $('#err_bp_total_number').html('').hide();
    }


    var bp_functional = $('#bp_functional').val();
    if(bp_functional == ''){
      $('#err_bp_functional').html('This field is required.').show();
      $('#bp_functional').focus();
      return false;
    } else {
      $('#err_bp_functional').html('').hide();
    }

    var bp_non_functional = $('#bp_non_functional').val();
    if(bp_non_functional == ''){
      $('#err_bp_non_functional').html('This field is required.').show();
      $('#bp_non_functional').focus();
      return false;
    } else {
      $('#err_bp_non_functional').html('').hide();
    }

    if(parseInt(bp_total_number) != parseInt(bp_functional)+parseInt(bp_non_functional)){
      $('#err_bp_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#bp_total_number').focus();
      return false;
    } else {
      $('#err_bp_total_number').html('').hide();
    }


    var tv_total_number = $('#tv_total_number').val();
    if(tv_total_number == ''){
      $('#err_tv_total_number').html('This field is required.').show();
      $('#tv_total_number').focus();
      return false;
    } else {
      $('#err_tv_total_number').html('').hide();
    }


    var tv_functional = $('#tv_functional').val();
    if(tv_functional == ''){
      $('#err_tv_functional').html('This field is required.').show();
      $('#tv_functional').focus();
      return false;
    } else {
      $('#err_tv_functional').html('').hide();
    }

    var tv_non_functional = $('#tv_non_functional').val();
    if(tv_non_functional == ''){
      $('#err_tv_non_functional').html('This field is required.').show();
      $('#tv_non_functional').focus();
      return false;
    } else {
      $('#err_tv_non_functional').html('').hide();
    }

    if(parseInt(tv_total_number) != parseInt(tv_functional)+parseInt(tv_non_functional)){
      $('#err_tv_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#tv_total_number').focus();
      return false;
    } else {
      $('#err_tv_total_number').html('').hide();
    }
    
    var clock_total_number = $('#clock_total_number').val();
    if(clock_total_number == ''){
      $('#err_clock_total_number').html('This field is required.').show();
      $('#clock_total_number').focus();
      return false;
    } else {
      $('#err_clock_total_number').html('').hide();
    }


    var clock_functional = $('#clock_functional').val();
    if(clock_functional == ''){
      $('#err_clock_functional').html('This field is required.').show();
      $('#clock_functional').focus();
      return false;
    } else {
      $('#err_clock_functional').html('').hide();
    }

    var clock_non_functional = $('#clock_non_functional').val();
    if(clock_non_functional == ''){
      $('#err_clock_non_functional').html('This field is required.').show();
      $('#clock_non_functional').focus();
      return false;
    } else {
      $('#err_clock_non_functional').html('').hide();
    }

    if(parseInt(clock_total_number) != parseInt(clock_functional)+parseInt(clock_non_functional)){
      $('#err_clock_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#clock_total_number').focus();
      return false;
    } else {
      $('#err_clock_total_number').html('').hide();
    }

    if($('.kmc_register').is(':checked')){
      $('#err_kmc_register').html('').hide();
    } else {
      $('#err_kmc_register').html('This field is required.').show();
      $('.kmc_register').focus();
      return false;
    }

    if($("#terms").is(':checked')){
      $('#err_terms').html('').hide();
    } else {
      $('#err_terms').html('Please check the checkbox.').show();
      return false;
    }


    var amenitiesRegisterOtpVerification = '<?php echo $admin_settings['amenitiesRegisterOtpVerification'] ?>';
    if(amenitiesRegisterOtpVerification == "1")
    {
      var check_otp = $('#otp_status').val();
      if(check_otp == 1){
        $('#modalPush').modal('show');
        //$('#err_mobile_verify').html('Please verify the mobile number.').show();
        return false;
      }
    }else{
      $('#form-save').submit();
    }

  });

  $('#submit_tab_3').click(function(event){
    //debugger;
    var staff_district_id = $('#staff_district_id').val();
    if(staff_district_id == ''){
      $('#err_staff_district_id').html('This field is required.').show();
      $('#staff_district_id').focus();
      return false;
    } else {
      $('#err_staff_district_id').html('').hide();
    }

    var staff_facility = $('#staff_facility').val();
    if(staff_facility == ''){
      $('#err_staff_facility').html('This field is required.').show();
      $('#staff_facility').focus();
      return false;
    } else {
      $('#err_staff_facility').html('').hide();
    }

    var staff_name = $('#staff_name').val();
    if(staff_name == ''){
      $('#err_staff_name').html('This field is required.').show();
      $('#staff_name').focus();
      return false;
    } else {
      $('#err_staff_name').html('').hide();
    }

    var mobile_number = $('#mobile_number').val();
    if(mobile_number == ''){
      $('#err_mobile_number').html('This field is required.').show();
      $('#mobile_number').focus();
      return false;
    } else {
      if(mobile_number != '' && mobile_number.length < 10){
        $('#err_mobile_number').html('Please enter valid Staff Mobile Number.').show();
        $('#mobile_number').focus();
        return false;
      } else if((mobile_number.charAt(0) != 9) && (mobile_number.charAt(0) != 8) && (mobile_number.charAt(0) != 7) && (mobile_number.charAt(0) != 6)){
        $('#err_mobile_number').css('color', 'red').text('Please enter valid Staff Mobile Number.').show();
        return false;
      } else {
        var chk_err = $('#err_mobile_number').html();
        if(chk_err.length >= 5){
          $('#mobile_number').focus();
          return false;
        } else {
          $('#err_mobile_number').html('').hide();
        }
      }
    }

    var emergency_number = $('#emergency_number').val();
    if(emergency_number != '' && emergency_number.length < 10 && (emergency_number.charAt(0) != 9) && (emergency_number.charAt(0) != 8) && (emergency_number.charAt(0) != 7) && (emergency_number.charAt(0) != 6)){
      $('#err_emergency_number').html('Please enter valid Emergency Contact Number.').show();
      $('#emergency_number').focus();
      return false;
    } else {
      $('#err_emergency_number').html('').hide();
    }

    var staff_type = $('#staff_type').val();
    if(staff_type == ''){
      $('#err_staff_type').html('This field is required.').show();
      $('#staff_type').focus();
      return false;
    } else {
      $('#err_staff_type').html('').hide();
    }

    var staff_sub_type_val = $('#staff_sub_type_val').val();
    if(staff_sub_type_val != ''){
      var staff_sub_type_other = $('#staff_sub_type_other').val();
      if(staff_sub_type_other == ''){
        $('#err_staff_sub_type_other').html('This field is required.').show();
        return false;
      }else {
        $('#err_staff_sub_type_other').html('').hide();
      }
    } else {
      $('#err_staff_sub_type_other').html('').hide();
    }





    // var staff_address = $('#staff_address').val();
    // if(staff_address == ''){
    //   $('#err_staff_address').html('This field is required.').show();
    //   $('#staff_address').focus();
    //   return false;
    // } else {
    //   $('#err_staff_address').html('').hide();
    // }



    // var staff_dob = $('#staff_dob').val();
    // if(staff_dob == ''){
    //   $('#err_staff_dob').html('This field is required.').show();
    //   $('#staff_dob').focus();
    //   return false;
    // } else {
    //   $('#err_staff_dob').html('').hide();
    // }

    // var staff_gender = $('#staff_gender').val();
    // if(staff_gender == ''){
    //   $('#err_staff_gender').html('This field is required.').show();
    //   $('#staff_gender').focus();
    //   return false;
    // } else {
    //   $('#err_staff_gender').html('').hide();
    // }

    // var staff_experiance = $('#staff_experiance').val();
    // if(staff_experiance == ''){
    //   $('#err_staff_experiance').html('This field is required.').show();
    //   $('#staff_experiance').focus();
    //   return false;
    // } else {
    //   $('#err_staff_experiance').html('').hide();
    // }


      if($("#staff_terms").is(':checked')){
        $('#err_staff_terms').html('').hide();
      } else {
        $('#err_staff_terms').html('Please check the checkbox.').show();
        return false;
      }

      var staffRegisterOtpVerification = '<?php echo $admin_settings['staffRegisterOtpVerification'] ?>';
      if(staffRegisterOtpVerification == "1")
      {
        var check_otp = $('#staff_otp_status').val();
        if(check_otp == 1){
          $('#modalPushStaff').modal('show');
          //$('#err_mobile_verify_staff').html('Please verify the mobile number.').show();
          return false;
        }
      }else{
        $('#form-staff-save').submit();
      }


  });


  function checkFacilityExist(val){
    if(val != ''){
      var url = '<?php echo base_url('RegistrationManagement/checkFacilityExist')?>';
      $.ajax({
          url: url,
          type: 'POST',
          data: {'val': val},
          success: function(result) {
             if(result != 1){
                $('#err_facility_name').html('This facility already exists.').show();
             } else {
                $('#err_facility_name').html('').hide();
             }
          }
      });
    } else {
      $('#err_facility_name').html('').hide();
    }
  }


  function checkLoungeExists(val){
    if(val != ''){
      var url = '<?php echo base_url('RegistrationManagement/checkLoungeExists')?>';
      $.ajax({
          url: url,
          type: 'POST',
          data: {'val': val},
          success: function(result) {
             if(result != 1){
                $('#err_lounge_name').html('This lounge already exists.').show();
             } else {
                $('#err_lounge_name').html('').hide();
             }
          }
      });
    } else {
      $('#err_lounge_name').html('').hide();
    }
  }

  function checkStaffMobile(val){
    if(val != '' && val.length == 10){
      var url = '<?php echo base_url('RegistrationManagement/checkStaffMobile')?>';
      $.ajax({
          url: url,
          type: 'POST',
          data: {'val': val},
          success: function(result) {
             if(result != 1){
                $('#err_mobile_number').html('This staff already exists.').show();
             } else {
                $('#err_mobile_number').html('').hide();
             }
          }
      });
    } else {
      $('#err_mobile_number').html('').hide();
    }
  }

  function enableButton(val, id){
    if(val != '' && val.length == 10){
      $('#'+id).html('').hide();
    } 
  }


  $('#fileInput').click(function(){ 
    $('#staffPhoto').trigger('click'); 
  });

  function getBlockList(dis_id) {

      if($('#block').is(":visible")) {
       
        var url = '<?php echo base_url('RegistrationManagement/getBlock/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id},
            success: function(result) {
                //alert(result);
                $("#block").html(result);
                // $('.selectpicker').selectpicker('refresh');
            }
        });
      } else {
        var url = '<?php echo base_url('RegistrationManagement/getVillageByDistrict/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id},
            success: function(result) {
                // alert(result);
                $("#village").html(result);
                // $('.selectpicker').selectpicker('refresh');
            }
        });
      }
  }


    


  function getVillageList(dis_id){

        //alert(dis_id);
        var url = '<?php echo base_url('RegistrationManagement/getVillage/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id': dis_id},
            success: function(result) {
                //console.log(result);
                $("#village").html(result);
                // $('.selectpicker').selectpicker('refresh');
            }
        });
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#dvPreviewImg').attr('src', e.target.result);
            $('#dvPreview').show();
        }

        reader.readAsDataURL(input.files[0]);
    }
}

  $("#staffPhoto").change(function () {
    var file = $('#staffPhoto')[0].files[0]['name']
    $('#fileInput').val(file);
    readURL(this);
    });

  
  $('.nav-link').click(function(){ 
    $(".nav-link").removeClass("active");
    $(this).addClass("active");   
  });

  
  setTimeout(function(){
      $('.alert-dismissible').hide();
  },5000);
    


  $(".m_b_n").keypress(function (e) {
        var id = $(this).attr('id');
        var value = $('#'+id).val();
        
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           
            return false;
        }
    });


  function showDataDiv(id, val) {
    if(val == 1){
      $('#div_'+id+'_2').hide();
      $('#div_'+id+'_1').show();
    } else {
      $('#div_'+id+'_1').hide();
      $('#div_'+id+'_2').show();
    }
  }

  




  function GetStaffSubType(get_id){
    
    var table = 'staffType';
    //alert(get_id);
    var s_url = '<?php echo base_url('RegistrationManagement/getStaffTypeList')?>';
          $.ajax({
              data: {'table': table, 'id': get_id},
              url: s_url,
              type: 'post',
              success: function(data) {
                  $('#staff_sub_type').html(data);
              }
          });
  }

  function openOtherStaffSubType(str){ 

    var selected_value = $('option:selected', str).attr('typevalue');
    if((selected_value == 'other') || (selected_value == 'others')){
      $('#staff_sub_type_other_div').show();
      $('#job_type_div1').hide();
      $('#job_type_div2').show();
      $('#staff_sub_type_val').val('Other');
    }else{
      $('#staff_sub_type_other_div').hide();
      $('#job_type_div1').show();
      $('#job_type_div2').hide();
      $('#staff_sub_type_val').val('');
    }
  }


  function sendOTP(){ 
    
    var mobile = $('#mobile_verify').val();
    if(mobile.length == 10) { 
      $('#err_mobile_verify').css('color','green').html('Please wait for otp.').show();
      var s_url = '<?php echo base_url('RegistrationManagement/sendOTP')?>';
      $.ajax({
              data: {'mobile': mobile},
              url: s_url,
              type: 'post',
              success: function(result) { 
                countdownTimer = setInterval('secondPassed()', 1000);
                seconds = 120;
                $('#countdown').show();
                $('#otpId').val(result);
                $('#hidden_mobile_verify').val(mobile);
                $('#mobile_span').html(mobile);
                $('#modalPush').modal('hide');
                $('#modalPushOtp').modal('show');
              }
          });
    } else {
      $('#err_mobile_verify').html('Please enter valid mobile number.').show();
    }
  }

  function sendOTPStaff(){
    
    var mobile = $('#mobile_verify_staff').val();
    if(mobile.length == 10) { 
      $('#err_mobile_verify_staff').css('color','green').html('Please wait for otp.').show();
      
      var s_url = '<?php echo base_url('RegistrationManagement/sendOTP')?>';
      $.ajax({
              data: {'mobile': mobile},
              url: s_url,
              type: 'post',
              success: function(result) { 
                countdownTimer2 = setInterval('secondPassed2()', 1000);
                seconds2 = 120;
                $('#countdownStaff').show();
                $('#otpIdStaff').val(result);
                $('#hidden_mobile_verify_staff').val(mobile);
                $('#mobile_span_staff').html(mobile);
                $('#modalPushStaff').modal('hide');
                $('#modalPushOtpStaff').modal('show');
                
              }
          });
    } else {
      $('#err_mobile_verify_staff').html('Please enter valid mobile number.').show();
    }
  }


  function resendSms(){
    $('#err_otp').html('').hide();
    $('#otp').val('');
    var id = $('#otpId').val();
    var mobile = $('#mobile_verify').val();
    var s_url = '<?php echo base_url('RegistrationManagement/resendOTP')?>';
      $.ajax({
              data: {'id': id, 'mobile': mobile},
              url: s_url,
              type: 'post',
              success: function(result) { 
                countdownTimer = setInterval('secondPassed()', 1000);
                seconds = 120;
                
                var href = '<input type="button" id="send" style="background-color: #00bcd4;" onclick="verifyOTP()" class="btn btn-sm send_otp" value="Verify OTP">';
                document.getElementById('otp_button').innerHTML = href;
                $('#countdown').show();
              }
          });
    }


  function resendSmsStaff(){
    $('#err_otp_staff').html('').hide();
    $('#otp_staff').val('');
    var id = $('#otpIdStaff').val();
    var mobile = $('#mobile_verify_staff').val();
    var s_url = '<?php echo base_url('RegistrationManagement/resendOTP')?>';
      $.ajax({
              data: {'id': id, 'mobile': mobile},
              url: s_url,
              type: 'post',
              success: function(result) { 
                countdownTimer2 = setInterval('secondPassed2()', 1000);
                seconds2 = 120;
                
                var href = '<input type="button" id="sendStaff" style="background-color: #00bcd4;" onclick="verifyOTPStaff()" class="btn btn-sm send_otp" value="Verify OTP">';
                document.getElementById('otp_button_staff').innerHTML = href;
                $('#countdownStaff').show();
                
              }
          });
    }


  function applyReadonly(id){
    if($("#"+id).is(':checked')){
      $('#err_'+id).html('').hide();
      $('#'+id).attr('disabled', true);
    } else {
      $('#'+id).attr('disabled', false);
    }
  }


  function showCheckDivStaff(){
    if($("#staff_terms").is(':checked')){
      $('#err_staff_terms').html('').hide();
      $('#check_div_staff').show();
    } else {
      $('#check_div_staff').hide();
    }
  }
  
  function removeDisable(otp){
    if(otp.length == 6){
      $('#err_otp').html('').hide();
    }
  }

  function removeDisableStaff(otp){
    if(otp.length == 6){
      $('#sendStaff').prop('disabled', false);
    }
  }

  function verifyOTP(){
    var id = $('#otpId').val();
    var mobile = $('#mobile_verify').val();
    var otp = $('#otp').val();
   
    if(otp.length == 6) {
      $('#err_otp').html('').hide();
      var s_url = '<?php echo base_url('RegistrationManagement/verifyOTP')?>';
      $.ajax({
              data: {'id': id, 'mobile': mobile, 'otp': otp},
              url: s_url,
              type: 'post',
              success: function(result) { 
                if(result == 1){
                  $('#countdown').html('');
                  $('#countdown').hide();
                  $('#otp_status').val('2');
                  $('#success-modal').html('<h1>Success!</h1><p>Your mobile number has been verified successfully.</p>');
                  setTimeout(function() {$('#modalPushOtp').modal('hide');
                    $('#form-save').submit();
                }, 2000);
                } else {
                  $('#err_otp').css('color', 'red').html('Incorrect OTP! Try Again.').show();
                  var href = '<input type="button" id="send" onclick="resendSms()" class="btn btn-sm btn-danger send_otp" value="Resend OTP">';
                  $('#countdown').html('');
                  $('#countdown').hide();
                  document.getElementById('otp_button').innerHTML = href;
                  $('#otp_status').val('1');
                  
                }
                clearInterval(countdownTimer);
              }
          });

    } else {
      $('#err_otp').html('Please enter six digit otp.').show();
    }
  }

  function verifyOTPStaff(){
    var id = $('#otpIdStaff').val();
    var mobile = $('#mobile_verify_staff').val();
    var otp = $('#otp_staff').val();

    if(otp.length == 6) {
      $('#err_otp_staff').html('').hide();
      var s_url = '<?php echo base_url('RegistrationManagement/verifyOTP')?>';
      $.ajax({
              data: {'id': id, 'mobile': mobile, 'otp': otp},
              url: s_url,
              type: 'post',
              success: function(result) { 
                if(result == 1){
                  $('#countdownStaff').html('');
                  $('#countdownStaff').hide();
                  $('#staff_otp_status').val('2');
                  $('#success-modal-staff').html('<h1>Success!</h1><p>Your mobile number has been verified successfully.</p>');
                  //setTimeout(function() {$('#modalPushOtpStaff').modal('hide');}, 2000);
                  setTimeout(function() {$('#modalPushOtpStaff').modal('hide');
                      $('#form-staff-save').submit();
                  }, 2000);
                } else {
                  $('#err_otp_staff').css('color', 'red').html('Incorrect OTP! Try Again.').show();
                  var href = '<input type="button" id="sendStaff" onclick="resendSmsStaff()" class="btn btn-sm btn-danger send_otp" value="Resend OTP">';
                  $('#countdownStaff').html('');
                  $('#countdownStaff').hide();
                  document.getElementById('otp_button_staff').innerHTML = href;
                  $('#staff_otp_status').val('1');
                  
                }
                clearInterval(countdownTimer2);
              }
          });
    } else {
      $('#err_otp_staff').html('Please enter six digit otp.').show();
    }
  }
</script>
<!-- <script>
    $('.selectpicker').selectpicker();
</script> -->
<script type="text/javascript">
    $(function () {
        $("#btnCloseStaffPopup").click(function () {
            $("#modalPushStaff").modal("hide");
        });
    });
</script>




<script type="text/javascript">
    $(function () {
        $("#btnClosePopup").click(function () {
            $("#modalPush").modal("hide");
        });
    });
</script>

<script type="text/javascript">
  // image zoom
  $('.without-caption').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300 // don't foget to change the duration also in CSS
    }
  });

  $('.with-caption').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    mainClass: 'mfp-with-zoom mfp-img-mobile',
    image: {
      verticalFit: true,
      titleSrc: function(item) {
        return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
      }
    },
    zoom: {
      enabled: true
    }
  });


</script>
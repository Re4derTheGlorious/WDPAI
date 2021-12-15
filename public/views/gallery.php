<!DOCTYPE html>
<head>
    <script type="text/javascript" src="./public/js/Navigation.js" defer></script>
    <script type="text/javascript" src="./public/js/Gallery.js" defer></script>
    <script type="text/javascript" src="./public/js/Auth.js" defer></script>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <title>re4tography</title>
</head>
<body>
    <div id="contents_panel"></div>
    <div id="buttons_panel">
        <button id="share_button" class="button_icon">
            <img src="public/res/icons/Icon_Share.svg">
        </button>
        <button id="fav_button" class="button_icon">
            <img src="public/res/icons/Icon_Fav.svg">
        </button>
        <button id="user_button" class="button_icon">
            <img src="public/res/icons/Icon_User.svg">
        </button>
        <button id="info_button"  class="button_icon">
            <img src="public/res/icons/Icon_Info.svg">
        </button>
        <button id="upload_button" class="button_icon">
            <img src="public/res/icons/Icon_Share.svg">
        </button>
    </div>
    <div id="fade" style="display:none;"></div>
    <div id="navigation_panel" style="display:contents;">
        <div id="left_nav_panel" class="nav_panel">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="nav_symbol">
                <polygon points="0,15 30,30 30,0"/>
            </svg>
        </div>
        <div id="right_nav_panel" class="nav_panel">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="nav_symbol">
                <polygon points="30,15 0,30 0,0"/>
            </svg>
        </div>
        <div id="bottom_nav_panel">
            <span id="nav_0" class="nav_ball" style="opacity:0.2; width:15px; height: 15px"></span>
            <span id="nav_1" class="nav_ball" style="opacity:0.4; width:22px; height: 22px"></span>
            <span id="nav_2" class="nav_ball" style="opacity:0.6; width:30px; height: 30px"></span>
            <span id="nav_3" class="nav_ball"></span>
            <span id="nav_4" class="nav_ball" style="opacity:0.6; width:30px; height: 30px"></span>
            <span id="nav_5" class="nav_ball" style="opacity:0.4; width:22px; height: 22px"></span>
            <span id="nav_6" class="nav_ball" style="opacity:0.2; width:15px; height: 15px"></span>
        </div>
    </div>
    <div id="about_panel" class="panel" style="display:none;">
        <div class="text_title">About me</div>
        <div class="text_panel">
            <p>&emsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sed mattis orci. Mauris sapien nulla, ultrices id est in, fermentum iaculis massa. Integer interdum mollis ligula, eget posuere elit luctus nec. Maecenas egestas elit eget odio commodo, dictum iaculis sem vulputate. Etiam sollicitudin euismod laoreet. Donec sed ullamcorper augue, et varius dui. Sed euismod metus vitae massa auctor aliquet.</p>
            <p>&emsp;Aenean eu malesuada massa, vitae sodales leo. Maecenas ac tellus molestie, efficitur purus vel, suscipit tellus. Proin convallis imperdiet elit, vitae consequat ligula tempor in. Quisque tempor ullamcorper velit, in vulputate ligula pharetra at. Morbi sodales augue at lacus molestie, eget condimentum nisi tincidunt. Mauris arcu metus, cursus vitae felis ac, pulvinar euismod nunc. Curabitur pharetra magna tellus, et tempor dolor sollicitudin eu. Integer mollis magna vel euismod tincidunt. Aliquam convallis, ante eget finibus hendrerit, mauris purus convallis lorem, et lobortis felis tellus non ex. Fusce consectetur tortor pulvinar nisi luctus, a facilisis justo pretium. Quisque dolor nibh, hendrerit quis hendrerit gravida, rutrum ut diam. Vivamus tincidunt purus sed sem placerat, eu dignissim nisi interdum. Aenean dictum vehicula consectetur. Pellentesque tempor nibh nec orci porttitor fringilla. Proin ut quam nunc. Nunc sed quam lobortis, mattis felis sed, condimentum ipsum.</p>
            <p>&emsp;Quisque aliquet quam ut odio congue varius. In sed elit bibendum, rutrum mauris ac, egestas nulla. Mauris vel felis efficitur, sagittis orci sollicitudin, placerat risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce blandit vestibulum massa, vitae sollicitudin odio scelerisque vitae. Vivamus elementum vehicula massa. Mauris et aliquet velit, eget tincidunt velit.</p>
            <p>&emsp;Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In congue, felis et posuere semper, eros arcu feugiat lacus, fermentum commodo felis magna id mi. Nulla venenatis aliquam lorem sed varius. Proin ultricies lacus sed elit posuere, id maximus urna venenatis. Aenean at est dolor. Morbi ac sodales ex. Curabitur fringilla justo vel neque venenatis dictum. Nulla sed sagittis diam, ac dapibus diam. Quisque cursus fringilla velit, quis laoreet purus venenatis convallis. Mauris et est ac nisl aliquam euismod. Sed nec iaculis tortor. Praesent vulputate ut eros ut scelerisque. Nulla sollicitudin sodales mollis. Phasellus molestie, enim non suscipit pellentesque, est lectus interdum nunc, in sagittis elit tortor ut lorem.</p>
            <p>&emsp;Duis ultrices quam non metus vehicula vulputate. Praesent eget ante sit amet sem ullamcorper pulvinar eget sed arcu. Quisque fringilla vel turpis condimentum hendrerit. Donec vel ligula diam. Aliquam elementum augue massa, at convallis dui dapibus quis. Nam commodo finibus lorem, vitae eleifend nisi. Ut ex dolor, porttitor sed massa sit amet, suscipit mollis mauris.</p>
        </div>
    </div>
    <div id="upload_panel" class="panel" style="display:none;">
        <div class="text_panel">
            <div class="text_title">New photo</div>
            <form action="uploadPhoto" method="POST" ENCTYPE="multipart/form-data">
                <input type="text" name="name_field" placeholder="Photo name">
                <input type="file" name="file">
                <div>
                    <button type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
    <div id="user_panel", class="panel", style="display:none;">
        <div class="text_title">User</div>
        <div>
            <input id='login_field' name="login_field" type="text" placeholder="Your Email">
            <input input id='pass_field' name="pass_field" type="password" placeholder="Your Password">
            <div>
                <button id='login_button'>Sign In</button>
                <button id="register_button">Sign Up</button>
                <button id="logoff_button">Log Off</button>
            </div>
        </div>
    </div>
</body>
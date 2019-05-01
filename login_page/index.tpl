<script src="login_page/login.js"></script>
<div class="content_box">
    <form method="POST" class="form-1">

        <p class="reg_btn">
            <button><i class="icon-user-plus icon-large"></i></button>
        </p>

        <input type="hidden" name="action" value="login">
        <div id="snackbar"></div>
        <p class="field">
            <input type="text" name="login" placeholder="Логин или email">
            <i class="icon-user icon-large"></i>
        </p>

        <p class="field">
            <input type="password" name="password" placeholder="Пароль">
            <i class="icon-lock icon-large"></i>
        </p>

        <p class="submit">
            <button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
        </p>

    </form>
</div>
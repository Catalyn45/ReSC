    <main>
        <div class="panel" id="main_panel">
            <h1 id="title">Login</h1>

            <form id="login_form" autocomplete=off>
                <div class="input_item">
                    <label for="username">Username/Email</label>
                    <input type="text" placeholder="username/email" id="username" name="username" required>
                </div>

                <div class="input_item">
                    <label for="password">Password</label>
                    <input type="password" placeholder="password" id="password" name="password" required>
                </div>

                <input type="submit" value="Login" class="submit_button">
                <button type="button" class="submit_button" onclick="location.href='/register'">I don't have an account</button>
            </form>
        </div>
    </main>

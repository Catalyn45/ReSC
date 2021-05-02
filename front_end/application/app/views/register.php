    <main>
        <div class="panel" id="main_panel">
            <h1 id="title">Register</h1>

            <form action="/public/register" method="POST">
                <div class="input_item">
                    <label for="username">Username</label>
                    <input type="text" placeholder="username" id="username" name="username">
                </div>

                <div class="input_item">
                    <label for="email">Email</label>
                    <input type="text" placeholder="email" id="email" name="email">
                </div>

                <div class="input_item">
                    <label for="password">Password</label>
                    <input type="password" placeholder="password" id="password" name="password">
                </div>

                <div class="input_item">
                    <label for="r_password">Repeat password</label>
                    <input type="password" placeholder="password" id="r_password">
                </div>

                <button type="submit" class="submit_button" id="register">Submit</button>
                <button type="button" class="submit_button" onclick="location.href='/public/login'">Already have an account</button>
            </form>
        </div>
    </main>

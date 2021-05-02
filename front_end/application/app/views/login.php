    <main>
        <div class="panel" id="main_panel">
            <h1 id="title">Login</h1>

            <form action="/public/register" method="POST">
                <div class="input_item">
                    <label for="username">Username/Email</label>
                    <input type="text" placeholder="username/email" id="username" name="username">
                </div>

                <div class="input_item">
                    <label for="password">Password</label>
                    <input type="password" placeholder="password" id="password" name="password">
                </div>

                <button type="button" class="submit_button" onclick="location.href='/public/settings'">Login</button>
                <button type="button" class="submit_button" onclick="location.href='/public/register'">I don't have an account</button>
            </form>
        </div>
    </main>

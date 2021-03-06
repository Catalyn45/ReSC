    <main>
        <div class="panel" id="main_panel">
            <h1 id="title">Register</h1>

            <form id="register_form" autocomplete=off>
                <div class="input_item">
                    <label for="username">Username</label>
                    <input type="text" placeholder="username" id="username" name="username" required>
                </div>

                <div class="input_item">
                    <label for="email">Email</label>
                    <input type="text" placeholder="email" id="email" name="email" required>
                </div>

                <div class="input_item">
                    <label for="password">Password</label>
                    <input type="password" placeholder="password" id="password" name="password" required>
                </div>

                <div class="input_item">
                    <label for="r_password">Repeat password</label>
                    <input type="password" placeholder="password" id="r_password" required>
                </div>

                <div class="input_item">
                    <label for="host">Host</label>
                    <input type="text" placeholder="host" id="host" required>
                </div>

                <input type="submit" class="submit_button" id="register" value="Submit">
                <button type="button" class="submit_button" onclick="location.href='/login'">Already have an account</button>
                <div id="message_board"></div>
            </form>
        </div>
    </main>

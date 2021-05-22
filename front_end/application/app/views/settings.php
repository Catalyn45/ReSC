    <main>
        <div class="panel" id="main_panel">
            <h1 id="title">Chat settings</h1>
            <div class="main_panel__elements">
                <div class="panel main_panel__elements__settings" id="colors_container">
                    <p>Colors</p>
                    <div id="chat_colors">
                        <div class="changeable" id="chat_colors__header"></div>
                        <div class="changeable" id="chat_colors__content">
                            <div class="changeable" id="chat_colors__content__me"></div>
                            <div class="changeable" id="chat_colors__content__stranger"></div>
                        </div>
                        <div id="chat_colors__bottom">
                            <div class="changeable" id="chat_colors__bottom__input"></div>
                            <div id="chat_colors__bottom__space"></div>
                            <div class="changeable" id="chat_colors__bottom__send"></div>
                        </div>
                    </div>
                </div>
                <div class="panel main_panel__elements__settings">
                    <p>Position</p>
                    <table id="position">
                        <tr>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <div></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <div></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <div id="selected"></div>
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="panel main_panel__elements__settings">
                    <p>Callback functions</p>
                    <div class="functions">
                        <div>
                            <label for="close_cb">Chat close callback:</label>
                            <input type="text" id="close_cb">
                        </div>
                        <div>
                            <label for="hide_cb">Chat hide callback:</label>
                            <input type="text" id="hide_cb">
                        </div>
                    </div>
                </div>
                <div class="panel main_panel__elements__settings">
                    <p>Class name</p>
                    <div class="functions">
                        <div>
                            <label for="class_name">Class name:</label>
                            <input type="text" id="class_name">
                        </div>
                    </div>

                </div>
                <div class="panel main_panel__elements__settings">
                    <p>Object name</p>
                    <div class="functions">
                        <div>
                            <label for="object_name">Object name:</label>
                            <input type="text" id="object_name">
                        </div>
                    </div>
                </div>
            </div>
            <div id="buttons">
                <button class="submit_button" onclick="send_configuration()">Save</button>
                <button class="submit_button">Cancel</button>
            </div>
        </div>
    </main>

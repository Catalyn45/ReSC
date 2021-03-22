function load_chat() {
    document.getElementById("try_demo").style.display = 'none';
    var script = document.createElement("script");
    var htmlRaw = 'https://catalyn45.github.io/ReSC/front_end/experimental/assets/js/autoload.js';
    script.src = htmlRaw;
    document.body.appendChild(script);
}
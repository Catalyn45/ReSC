import re
import sys

'''
    Use this script to generate the autoload file
    
    How to use:
        python autoload_gen.py <html_file> <script_file> <output_file>
    
    javascript file need to have "\\3152_insert_here" to know where to insert
'''

text_pattern = b'''
var htmlRaw = `\r\n%s\r\n`
document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" type="text/css" href="https://catalyn45.github.io/ReSC/front_end/experimental/assets/css/style.css"/>');
document.body.insertAdjacentHTML("beforeend", htmlRaw);
'''


def parse_file(html_path, script_path, output_path):
    with open(html_path, "rb") as file:
        html_content = file.read()

    result = re.match(b'.*<body>\s*(.*?)\s*<div\s*class\s*=\s*"content".*', html_content, re.DOTALL | re.IGNORECASE)
    raw_html = result.group(1)

    text_to_insert = text_pattern % raw_html
    print(text_to_insert)

    with open(script_path, "rb") as file:
        script_content = file.read()

    script_content = script_content.replace(b"//3152_insert_here", text_to_insert)
    
    print(script_content)

    with open(output_path, "wb") as file:
        print("am deschis")
        file.write(script_content)


if __name__ == '__main__':
    html_path = r"..\..\index.html"
    script_path = r"script.js"
    output_path = r"autoload.js"

    if len(sys.argv) >= 4:
        html_path = sys.argv[1]
        script_path = sys.argv[2]
        output_path = sys.argv[3]

    parse_file(html_path, script_path, output_path)

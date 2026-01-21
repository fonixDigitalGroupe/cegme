import os

file_path = r'c:\Users\LANDING DIALLO\Desktop\Projects\cegme\cegme\cegme\cegme\resources\views\realisations.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Replace Header
header_start_marker = '<header class="w-full bg-white sticky top-0 z-50"'
header_end_marker = '</header>'

h_start = content.find(header_start_marker)
h_end = content.find(header_end_marker, h_start)

if h_start != -1 and h_end != -1:
    h_end += len(header_end_marker)
    content = content[:h_start] + '<x-site-header />' + content[h_end:]
    print("Header replaced.")
else:
    print("Header not found or markers invalid.")

# 2. Replace Footer (Both Desktop and Mobile)
# Start at "<!-- Footer - Exact from Site -->"
# End before "<!-- Mobile Menu JavaScript -->"

footer_start_marker = '<!-- Footer - Exact from Site -->'
footer_end_marker = '<!-- Mobile Menu JavaScript -->'

f_start = content.find(footer_start_marker)
f_end = content.find(footer_end_marker)

if f_start != -1 and f_end != -1:
    content = content[:f_start] + '<x-site-footer />\n\n    ' + content[f_end:]
    print("Footers replaced.")
else:
    print("Footers not found.")

# 3. Replace Scripts
# Start at "<!-- Mobile Menu JavaScript -->"
# End at "</script>" relative to that.

script_start_marker = '<!-- Mobile Menu JavaScript -->'
script_end_marker = '</script>'

s_start = content.find(script_start_marker)
if s_start != -1:
    s_end = content.find(script_end_marker, s_start)
    if s_end != -1:
        s_end += len(script_end_marker)
        content = content[:s_start] + "@include('partials.site-scripts')" + content[s_end:]
        print("Scripts replaced.")
    else:
        print("Script end marker not found.")
else:
    print("Script start marker not found.")

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Refactoring complete.")

import os

file_path = r'c:\Users\LANDING DIALLO\Desktop\Projects\cegme\cegme\cegme\cegme\resources\views\services.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Markers
start_marker = '<!-- Footer - Exact from Site -->'
end_marker = '@include(\'partials.site-scripts\')'

start_idx = content.find(start_marker)
end_idx = content.find(end_marker)

if start_idx == -1:
    print("Start marker not found")
    exit(1)

if end_idx == -1:
    print("End marker not found")
    exit(1)

# We want to replace everything from start_marker to just before end_marker
# with <x-site-footer />

new_content = content[:start_idx] + '    <x-site-footer />\n\n    ' + content[end_idx:]

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_content)

print("Successfully refactored services.blade.php")

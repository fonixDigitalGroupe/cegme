$filePath = "c:\Users\LANDING DIALLO\Desktop\Projects\cegme\cegme\cegme\cegme\resources\views\services.blade.php"
$content = Get-Content -Path $filePath -Raw -Encoding UTF8

$startMarker = "<!-- Footer - Exact from Site -->"
$endMarker = "@include('partials.site-scripts')"

$startIndex = $content.IndexOf($startMarker)
$endIndex = $content.IndexOf($endMarker)

if ($startIndex -eq -1) {
    Write-Host "Start marker not found"
    exit 1
}

if ($endIndex -eq -1) {
    Write-Host "End marker not found"
    exit 1
}

$newContent = $content.Substring(0, $startIndex) + "    <x-site-footer />`r`n`r`n    " + $content.Substring($endIndex)
Set-Content -Path $filePath -Value $newContent -Encoding UTF8
Write-Host "Successfully refactored services.blade.php"

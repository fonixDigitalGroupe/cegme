$filePath = "c:\Users\LANDING DIALLO\Desktop\Projects\cegme\cegme\cegme\cegme\resources\views\realisations.blade.php"
$content = Get-Content -Path $filePath -Raw -Encoding UTF8

# 1. Header
$headerStartMarker = '<header class="w-full bg-white sticky top-0 z-50"'
$headerEndMarker = '</header>'
$hStart = $content.IndexOf($headerStartMarker)
$hEnd = $content.IndexOf($headerEndMarker, $hStart)

if ($hStart -ne -1 -and $hEnd -ne -1) {
    $hEnd += $headerEndMarker.Length
    $content = $content.Substring(0, $hStart) + "<x-site-header />" + $content.Substring($hEnd)
    Write-Host "Header replaced."
} else {
    Write-Host "Header markers not found."
}

# 2. Body/Footer (Must search again in new content)
$footerStartMarker = "<!-- Footer - Exact from Site -->"
$footerEndMarker = "<!-- Mobile Menu JavaScript -->"

$fStart = $content.IndexOf($footerStartMarker)
$fEnd = $content.IndexOf($footerEndMarker)

if ($fStart -ne -1 -and $fEnd -ne -1) {
    $content = $content.Substring(0, $fStart) + "    <x-site-footer />`r`n`r`n" + $content.Substring($fEnd)
    Write-Host "Footers replaced."
} else {
    Write-Host "Footer markers not found."
}

# 3. Scripts (Search again)
$scriptStartMarker = "<!-- Mobile Menu JavaScript -->"
$scriptEndMarker = "</script>"

$sStart = $content.IndexOf($scriptStartMarker)
if ($sStart -ne -1) {
    $sEnd = $content.IndexOf($scriptEndMarker, $sStart)
    if ($sEnd -ne -1) {
        $sEnd += $scriptEndMarker.Length
        $content = $content.Substring(0, $sStart) + "@include('partials.site-scripts')" + $content.Substring($sEnd)
        Write-Host "Scripts replaced."
    } else {
        Write-Host "Script end marker not found."
    }
} else {
    Write-Host "Script start marker not found."
}

Set-Content -Path $filePath -Value $content -Encoding UTF8
Write-Host "Refactoring complete."

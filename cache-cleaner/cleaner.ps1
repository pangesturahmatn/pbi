Add-Type -AssemblyName System.Windows.Forms
Add-Type -AssemblyName System.Drawing
[System.Windows.Forms.Application]::EnableVisualStyles()

# Create form
$form = New-Object Windows.Forms.Form
$form.Text = "Laragon & System Optimizers (Cleaner & Audit)"
$form.Size = New-Object Drawing.Size(580, 680)
$form.StartPosition = "CenterScreen"
$form.FormBorderStyle = "FixedSingle"
$form.MaximizeBox = $false
$form.BackColor = [Drawing.Color]::FromArgb(30, 30, 46) # Dark theme background

# Custom Fonts
$fontTitle = New-Object Drawing.Font("Segoe UI", 16, [Drawing.FontStyle]::Bold)
$fontLabel = New-Object Drawing.Font("Segoe UI", 11, [Drawing.FontStyle]::Regular)
$fontLabelBold = New-Object Drawing.Font("Segoe UI", 11, [Drawing.FontStyle]::Bold)
$fontValue = New-Object Drawing.Font("Segoe UI", 11, [Drawing.FontStyle]::Bold)
$fontButton = New-Object Drawing.Font("Segoe UI", 10, [Drawing.FontStyle]::Bold)
$fontLog = New-Object Drawing.Font("Consolas", 9, [Drawing.FontStyle]::Regular)
$fontWarning = New-Object Drawing.Font("Segoe UI", 9.5, [Drawing.FontStyle]::Bold)

# Colors
$colorText = [Drawing.Color]::FromArgb(205, 214, 244)
$colorSubtext = [Drawing.Color]::FromArgb(166, 173, 200)
$colorAccent = [Drawing.Color]::FromArgb(137, 180, 250)
$colorButtonText = [Drawing.Color]::FromArgb(17, 17, 27)
$colorLogBg = [Drawing.Color]::FromArgb(17, 17, 27)
$colorWarning = [Drawing.Color]::FromArgb(250, 179, 135) # Peach/Orange
$colorGreen = [Drawing.Color]::FromArgb(166, 227, 161) # Green
$colorRed = [Drawing.Color]::FromArgb(243, 139, 168) # Red

# Title Label
$titleLabel = New-Object Windows.Forms.Label
$titleLabel.Text = "System Optimizer & Audit"
$titleLabel.Font = $fontTitle
$titleLabel.ForeColor = $colorAccent
$titleLabel.Location = New-Object Drawing.Point(20, 15)
$titleLabel.Size = New-Object Drawing.Size(520, 35)
$form.Controls.Add($titleLabel)

# Tab Control Setup
$tabControl = New-Object Windows.Forms.TabControl
$tabControl.Location = New-Object Drawing.Point(20, 60)
$tabControl.Size = New-Object Drawing.Size(525, 560)
$form.Controls.Add($tabControl)

# TAB 1: Cleaner Tab
$tabCleaner = New-Object Windows.Forms.TabPage
$tabCleaner.Text = "Pembersih Cache"
$tabCleaner.BackColor = [Drawing.Color]::FromArgb(30, 30, 46)
$tabControl.TabPages.Add($tabCleaner)

# TAB 2: Security Tab
$tabSecurity = New-Object Windows.Forms.TabPage
$tabSecurity.Text = "Audit Keamanan & Performa"
$tabSecurity.BackColor = [Drawing.Color]::FromArgb(30, 30, 46)
$tabControl.TabPages.Add($tabSecurity)

# --- TAB 1: CLEANER LAYOUT ---
$descLabel = New-Object Windows.Forms.Label
$descLabel.Text = "Bersihkan file sampah sementara untuk membebaskan ruang penyimpanan."
$descLabel.Font = New-Object Drawing.Font("Segoe UI", 9.5, [Drawing.FontStyle]::Regular)
$descLabel.ForeColor = $colorSubtext
$descLabel.Location = New-Object Drawing.Point(15, 15)
$descLabel.Size = New-Object Drawing.Size(490, 20)
$tabCleaner.Controls.Add($descLabel)

# Paths config
$username = $env:USERNAME
$paths = @(
    @{ Name = "Windows User Temp"; Paths = @("C:\Users\$username\AppData\Local\Temp", "C:\Windows\Temp") },
    @{ Name = "NPM Cache"; Paths = @("C:\Users\$username\AppData\Local\npm-cache") },
    @{ Name = "Laragon Tmp"; Paths = @("C:\laragon\tmp") },
    @{ 
        Name = "Google Chrome Cache & History"
        Paths = @(
            "C:\Users\$username\AppData\Local\Google\Chrome\User Data\Default\Cache",
            "C:\Users\$username\AppData\Local\Google\Chrome\User Data\Default\Code Cache",
            "C:\Users\$username\AppData\Local\Google\Chrome\User Data\Default\History"
        ) 
    },
    @{ 
        Name = "Microsoft Edge Cache & History"
        Paths = @(
            "C:\Users\$username\AppData\Local\Microsoft\Edge\User Data\Default\Cache",
            "C:\Users\$username\AppData\Local\Microsoft\Edge\User Data\Default\Code Cache",
            "C:\Users\$username\AppData\Local\Microsoft\Edge\User Data\Default\History"
        ) 
    },
    @{ Name = "Windows Update Cache"; Paths = @("C:\Windows\SoftwareDistribution\Download", "C:\Windows\SoftwareDistribution\DeliveryOptimization") },
    @{ Name = "System Logs & Prefetch"; Paths = @("C:\Windows\Logs", "C:\Windows\Prefetch") }
)

# Helper function to get size
function Get-SinglePathSize($path) {
    if (-not (Test-Path $path)) { return 0 }
    if (Test-Path -Path $path -PathType Leaf) {
        return (Get-Item $path).Length
    } else {
        $size = (Get-ChildItem $path -Recurse -File -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum
        if ($null -eq $size) { return 0 }
        return $size
    }
}

function Get-PathsSize($pathList) {
    $total = 0
    foreach ($p in $pathList) { $total += Get-SinglePathSize $p }
    return $total
}

# Format size
function Format-Size($bytes) {
    if ($bytes -ge 1GB) { return "$([math]::Round($bytes/1GB, 2)) GB" }
    elseif ($bytes -ge 1MB) { return "$([math]::Round($bytes/1MB, 2)) MB" }
    elseif ($bytes -ge 1KB) { return "$([math]::Round($bytes/1KB, 2)) KB" }
    else { return "$bytes Bytes" }
}

$values = @()
$y = 45

for ($i = 0; $i -lt $paths.Count; $i++) {
    $item = $paths[$i]
    
    $lbl = New-Object Windows.Forms.Label
    $lbl.Text = $item.Name
    $lbl.Font = $fontLabel
    $lbl.ForeColor = $colorText
    $lbl.Location = New-Object Drawing.Point(20, $y)
    $lbl.Size = New-Object Drawing.Size(250, 22)
    $tabCleaner.Controls.Add($lbl)
    
    $val = New-Object Windows.Forms.Label
    $val.Text = "Menghitung..."
    $val.Font = $fontValue
    $val.ForeColor = $colorAccent
    $val.Location = New-Object Drawing.Point(280, $y)
    $val.Size = New-Object Drawing.Size(150, 22)
    $tabCleaner.Controls.Add($val)
    
    $values += $val
    $y += 26
}

# Total
$lblTotal = New-Object Windows.Forms.Label
$lblTotal.Text = "Total Sampah:"
$lblTotal.Font = New-Object Drawing.Font("Segoe UI", 11, [Drawing.FontStyle]::Bold)
$lblTotal.ForeColor = $colorText
$lblTotal.Location = New-Object Drawing.Point(20, $y + 5)
$lblTotal.Size = New-Object Drawing.Size(250, 25)
$tabCleaner.Controls.Add($lblTotal)

$valTotal = New-Object Windows.Forms.Label
$valTotal.Text = "Menghitung..."
$valTotal.Font = New-Object Drawing.Font("Segoe UI", 13, [Drawing.FontStyle]::Bold)
$valTotal.ForeColor = $colorRed
$valTotal.Location = New-Object Drawing.Point(280, $y + 3)
$valTotal.Size = New-Object Drawing.Size(180, 30)
$tabCleaner.Controls.Add($valTotal)

# Log Box
$logBox = New-Object Windows.Forms.TextBox
$logBox.Multiline = $true
$logBox.ReadOnly = $true
$logBox.ScrollBars = "Vertical"
$logBox.Font = $fontLog
$logBox.BackColor = $colorLogBg
$logBox.ForeColor = $colorText
$logBox.BorderStyle = [System.Windows.Forms.BorderStyle]::FixedSingle
$logBox.Location = New-Object Drawing.Point(15, ($y + 35))
$logBox.Size = New-Object Drawing.Size(490, 130)
$tabCleaner.Controls.Add($logBox)

# Warnings Label
$lblWarning = New-Object Windows.Forms.Label
$lblWarning.Text = ""
$lblWarning.Font = $fontWarning
$lblWarning.ForeColor = $colorWarning
$lblWarning.Location = New-Object Drawing.Point(15, ($y + 170))
$lblWarning.Size = New-Object Drawing.Size(490, 45)
$tabCleaner.Controls.Add($lblWarning)

# Buttons
$btnScan = New-Object Windows.Forms.Button
$btnScan.Text = "Pindai Ulang"
$btnScan.Font = $fontButton
$btnScan.BackColor = [Drawing.Color]::FromArgb(49, 50, 68)
$btnScan.ForeColor = $colorText
$btnScan.Location = New-Object Drawing.Point(235, ($y + 218))
$btnScan.Size = New-Object Drawing.Size(110, 35)
$btnScan.FlatStyle = "Flat"
$btnScan.FlatAppearance.BorderSize = 0
$btnScan.Add_Click({ Update-Sizes })
$tabCleaner.Controls.Add($btnScan)

$btnClean = New-Object Windows.Forms.Button
$btnClean.Text = "Bersihkan"
$btnClean.Font = $fontButton
$btnClean.BackColor = $colorAccent
$btnClean.ForeColor = $colorButtonText
$btnClean.Location = New-Object Drawing.Point(355, ($y + 218))
$btnClean.Size = New-Object Drawing.Size(150, 35)
$btnClean.FlatStyle = "Flat"
$btnClean.FlatAppearance.BorderSize = 0
$btnClean.Enabled = $false
$tabCleaner.Controls.Add($btnClean)

# Logs helper
function Add-Log($msg) {
    $logBox.AppendText($msg + "`r`n")
    $logBox.SelectionStart = $logBox.TextLength
    $logBox.ScrollToCaret()
}

# Warnings logic
function Update-Warnings() {
    $warnings = @()
    if (Get-Process -Name "httpd", "nginx", "mysqld", "postgres" -ErrorAction SilentlyContinue) { $warnings += "Laragon" }
    if (Get-Process -Name "chrome" -ErrorAction SilentlyContinue) { $warnings += "Google Chrome" }
    if (Get-Process -Name "msedge" -ErrorAction SilentlyContinue) { $warnings += "Microsoft Edge" }
    
    if ($warnings.Count -gt 0) {
        $lblWarning.Text = "[HIMBAUAN] Tutup (" + ($warnings -join ", ") + ") sebelum klik Bersihkan agar pembersihan file & history berjalan maksimal."
    } else {
        $lblWarning.Text = "[OK] Semua aplikasi target sudah ditutup. Siap dibersihkan total."
    }
}

# Scan sizes logic
function Update-Sizes() {
    $totalBytes = 0
    Add-Log "Memindai folder sampah..."
    Update-Warnings
    
    for ($i = 0; $i -lt $paths.Count; $i++) {
        $item = $paths[$i]
        $size = Get-PathsSize $item.Paths
        $totalBytes += $size
        $values[$i].Text = Format-Size $size
        [System.Windows.Forms.Application]::DoEvents()
    }
    
    $valTotal.Text = Format-Size $totalBytes
    Add-Log "Pemindaian selesai. Total sampah ditemukan: $(Format-Size $totalBytes)"
    Add-Log "--------------------------------------------"
    
    if ($totalBytes -gt 0) {
        $btnClean.Enabled = $true
        $btnClean.BackColor = $colorAccent
    } else {
        $btnClean.Enabled = $false
        $btnClean.BackColor = [Drawing.Color]::Gray
    }
}

# Clean logic
function Clean-SinglePath($path) {
    if (-not (Test-Path $path)) { return 0 }
    $freed = 0
    if (Test-Path -Path $path -PathType Leaf) {
        try {
            $len = (Get-Item $path).Length
            Remove-Item $path -Force -ErrorAction Stop
            $freed = $len
        } catch {}
    } else {
        $files = Get-ChildItem $path -Force -ErrorAction SilentlyContinue
        foreach ($f in $files) {
            $fPath = $f.FullName
            try {
                $fSize = 0
                if (-not $f.PSIsContainer) { $fSize = $f.Length }
                Remove-Item $fPath -Recurse -Force -ErrorAction Stop
                $freed += $fSize
            } catch {}
        }
    }
    return $freed
}

$btnClean.Add_Click({
    $btnClean.Enabled = $false
    $btnScan.Enabled = $false
    
    Add-Log "Memulai proses pembersihan..."
    $freedTotal = 0
    
    foreach ($item in $paths) {
        Add-Log "Membersihkan: $($item.Name)..."
        [System.Windows.Forms.Application]::DoEvents()
        
        $categoryFreed = 0
        foreach ($p in $item.Paths) { $categoryFreed += Clean-SinglePath $p }
        $freedTotal += $categoryFreed
        Add-Log "  -> Berhasil menghapus $(Format-Size $categoryFreed)"
    }
    
    Add-Log "Pembersihan selesai!"
    Add-Log "Total ruang yang berhasil dibebaskan: $(Format-Size $freedTotal)"
    Add-Log "--------------------------------------------"
    
    $btnScan.Enabled = $true
    Update-Sizes
})

# --- TAB 2: SECURITY LAYOUT ---
$secTitle = New-Object Windows.Forms.Label
$secTitle.Text = "Status Keamanan & Performa PC Anda:"
$secTitle.Font = $fontLabelBold
$secTitle.ForeColor = $colorAccent
$secTitle.Location = New-Object Drawing.Point(15, 15)
$secTitle.Size = New-Object Drawing.Size(490, 25)
$tabSecurity.Controls.Add($secTitle)

$secItems = @(
    @{ Label = "Windows Defender Antivirus"; ValueId = "lblDefStatus" },
    @{ Label = "Real-time Protection"; ValueId = "lblRealTime" },
    @{ Label = "Akses Remote Desktop (RDP)"; ValueId = "lblRDPStatus" },
    @{ Label = "Deteksi Aplikasi Remote (AnyDesk dll)"; ValueId = "lblRemoteApps" },
    @{ Label = "Integritas File Hosts"; ValueId = "lblHostsStatus" }
)

$secValues = @{}
$sy = 45

foreach ($item in $secItems) {
    $lbl = New-Object Windows.Forms.Label
    $lbl.Text = $item.Label
    $lbl.Font = $fontLabel
    $lbl.ForeColor = $colorText
    $lbl.Location = New-Object Drawing.Point(20, $sy)
    $lbl.Size = New-Object Drawing.Size(260, 22)
    $tabSecurity.Controls.Add($lbl)
    
    $val = New-Object Windows.Forms.Label
    $val.Text = "Memindai..."
    $val.Font = $fontValue
    $val.ForeColor = $colorAccent
    $val.Location = New-Object Drawing.Point(290, $sy)
    $val.Size = New-Object Drawing.Size(210, 22)
    $tabSecurity.Controls.Add($val)
    
    $secValues[$item.ValueId] = $val
    $sy += 26
}

# CPU Performance
$lblCpuTitle = New-Object Windows.Forms.Label
$lblCpuTitle.Text = "Aplikasi Mengonsumsi CPU Tertinggi (Paling Berat):"
$lblCpuTitle.Font = $fontLabelBold
$lblCpuTitle.ForeColor = $colorAccent
$lblCpuTitle.Location = New-Object Drawing.Point(15, ($sy + 10))
$lblCpuTitle.Size = New-Object Drawing.Size(490, 25)
$tabSecurity.Controls.Add($lblCpuTitle)

$txtCpuList = New-Object Windows.Forms.TextBox
$txtCpuList.Multiline = $true
$txtCpuList.ReadOnly = $true
$txtCpuList.Font = $fontLog
$txtCpuList.BackColor = $colorLogBg
$txtCpuList.ForeColor = $colorText
$txtCpuList.BorderStyle = [System.Windows.Forms.BorderStyle]::FixedSingle
$txtCpuList.Location = New-Object Drawing.Point(15, ($sy + 40))
$txtCpuList.Size = New-Object Drawing.Size(490, 80)
$tabSecurity.Controls.Add($txtCpuList)

# Tips
$lblTips = New-Object Windows.Forms.Label
$lblTips.Text = "[TIPS] Jika komputer terasa panas atau lag, periksa daftar aplikasi dengan akumulasi waktu CPU tertinggi di atas. Tutup program yang memakan banyak daya."
$lblTips.Font = New-Object Drawing.Font("Segoe UI", 9.0, [Drawing.FontStyle]::Italic)
$lblTips.ForeColor = $colorSubtext
$lblTips.Location = New-Object Drawing.Point(15, ($sy + 130))
$lblTips.Size = New-Object Drawing.Size(490, 45)
$tabSecurity.Controls.Add($lblTips)

# Audit Button
$btnAudit = New-Object Windows.Forms.Button
$btnAudit.Text = "Pindai Keamanan & CPU"
$btnAudit.Font = $fontButton
$btnAudit.BackColor = $colorAccent
$btnAudit.ForeColor = $colorButtonText
$btnAudit.Location = New-Object Drawing.Point(305, ($sy + 185))
$btnAudit.Size = New-Object Drawing.Size(200, 35)
$btnAudit.FlatStyle = "Flat"
$btnAudit.FlatAppearance.BorderSize = 0
$btnAudit.Add_Click({ Run-SecurityAudit })
$tabSecurity.Controls.Add($btnAudit)

# Security Audit Logic
function Run-SecurityAudit() {
    $btnAudit.Enabled = $false
    $txtCpuList.Text = "Menganalisa performa..."
    
    # 1. Antivirus / Defender check
    try {
        $mp = Get-MpComputerStatus -ErrorAction SilentlyContinue
        if ($null -ne $mp) {
            if ($mp.AntivirusEnabled) {
                $secValues["lblDefStatus"].Text = "[OK] Aktif"
                $secValues["lblDefStatus"].ForeColor = $colorGreen
            } else {
                $secValues["lblDefStatus"].Text = "[WARN] Nonaktif"
                $secValues["lblDefStatus"].ForeColor = $colorRed
            }
            if ($mp.RealTimeProtectionEnabled) {
                $secValues["lblRealTime"].Text = "[OK] Aktif"
                $secValues["lblRealTime"].ForeColor = $colorGreen
            } else {
                $secValues["lblRealTime"].Text = "[WARN] Nonaktif"
                $secValues["lblRealTime"].ForeColor = $colorRed
            }
        } else {
            $secValues["lblDefStatus"].Text = "Tidak terdeteksi"
            $secValues["lblRealTime"].Text = "Tidak terdeteksi"
        }
    } catch {
        $secValues["lblDefStatus"].Text = "Gagal Pindai"
        $secValues["lblRealTime"].Text = "Gagal Pindai"
    }
    
    # 2. Remote Desktop (RDP) check
    $rdpKey = Get-ItemProperty -Path 'HKLM:\System\CurrentControlSet\Control\Terminal Server' -Name "fDenyTSConnections" -ErrorAction SilentlyContinue
    if ($null -ne $rdpKey -and $rdpKey.fDenyTSConnections -eq 0) {
        $secValues["lblRDPStatus"].Text = "[WARN] Terbuka (Aktif)"
        $secValues["lblRDPStatus"].ForeColor = $colorRed
    } else {
        $secValues["lblRDPStatus"].Text = "[OK] Tertutup (Aman)"
        $secValues["lblRDPStatus"].ForeColor = $colorGreen
    }
    
    # 3. Detect remote apps running
    $remoteApps = @()
    $processes = Get-Process -ErrorAction SilentlyContinue
    foreach ($p in $processes) {
        if ($p.Name -match "anydesk|teamviewer|ultraviewer|rustdesk|tv_w32|remoting_host") {
            $remoteApps += $p.Name
        }
    }
    if ($remoteApps.Count -gt 0) {
        $secValues["lblRemoteApps"].Text = "[WARN] Terdeteksi ($($remoteApps -join ', '))"
        $secValues["lblRemoteApps"].ForeColor = $colorWarning
    } else {
        $secValues["lblRemoteApps"].Text = "[OK] Bersih (Tidak ada)"
        $secValues["lblRemoteApps"].ForeColor = $colorGreen
    }
    
    # 4. Hosts File check
    $hostsPath = "C:\Windows\System32\drivers\etc\hosts"
    if (Test-Path $hostsPath) {
        $lines = Get-Content $hostsPath | Where-Object { $_ -match "^\s*[^#\s]" -and $_ -notmatch "127\.0\.0\.1|::1|localhost" }
        if ($null -ne $lines -and $lines.Count -gt 0) {
            $secValues["lblHostsStatus"].Text = "[WARN] Modifikasi Kustom"
            $secValues["lblHostsStatus"].ForeColor = $colorWarning
        } else {
            $secValues["lblHostsStatus"].Text = "[OK] Aman (Standar)"
            $secValues["lblHostsStatus"].ForeColor = $colorGreen
        }
    } else {
        $secValues["lblHostsStatus"].Text = "[WARN] File Hilang!"
        $secValues["lblHostsStatus"].ForeColor = $colorRed
    }
    
    # 5. CPU Consumption
    # Helper to format CPU seconds into days, hours, minutes, seconds
    function Format-CpuTime($seconds) {
        $ts = [TimeSpan]::FromSeconds($seconds)
        $parts = @()
        if ($ts.Days -gt 0) { $parts += "$($ts.Days) hari" }
        if ($ts.Hours -gt 0) { $parts += "$($ts.Hours) jam" }
        if ($ts.Minutes -gt 0) { $parts += "$($ts.Minutes) menit" }
        if ($ts.Seconds -gt 0 -or $parts.Count -eq 0) { $parts += "$($ts.Seconds) detik" }
        return $parts -join " "
    }

    # Get top 3 CPU consuming processes, skipping Idle
    $cpuProcs = Get-Process | Where-Object { $_.Name -ne "Idle" -and $_.CPU -gt 0 } | Sort-Object CPU -Descending | Select-Object -First 3 -ErrorAction SilentlyContinue
    $cpuText = ""
    if ($null -ne $cpuProcs) {
        foreach ($proc in $cpuProcs) {
            $cpuFormatted = Format-CpuTime $proc.CPU
            $cpuText += "  - $($proc.Name) (ID: $($proc.Id)) - Waktu Kerja CPU: $cpuFormatted`r`n"
        }
    } else {
        $cpuText = "Tidak ada proses berat terdeteksi."
    }
    $txtCpuList.Text = $cpuText
    
    $btnAudit.Enabled = $true
}

# Initial trigger
$form.Add_Shown({
    Update-Sizes
    Run-SecurityAudit
})

# Show form
$form.ShowDialog()

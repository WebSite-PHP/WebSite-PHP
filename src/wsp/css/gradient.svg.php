<?php 
header("Content-Type: image/svg+xml");
echo "<?xml version=\"1.0\" standalone=\"no\"?>\n"; 
?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg width="100" height="2000" version="1.1" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="Css3GradientBoxTitleSvg<?php echo $_GET['i']; ?>" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="5%" style="stop-color:<?php echo $_GET['stop']; ?>;stop-opacity:1"/>
            <stop offset="70%" style="stop-color:<?php echo $_GET['start']; ?>;stop-opacity:1"/>
        </linearGradient>
    </defs>
    <rect x="0" y="0" width="100" height="2000" style="fill:url(#Css3GradientBoxTitleSvg<?php echo $_GET['i']; ?>)" />
</svg>
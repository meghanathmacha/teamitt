#!/bin/bash
#written via TheeMahn

#set Base, hilight color & header please adjust colors in hex and font to your liking
BASE='${color #cccccc}'
HILIGHT='${color #ffff00}'
HEADER='${color #ffffff}${font Liberation:style=Bold:pixelsize=12}'
BAR='${color #00ff00}'

#Get CPU model
PROC=`cat /proc/cpuinfo | grep 'model name' | sed -e 's/.*: //' | uniq`
echo $PROC

#check Architecture set 32 bit default
ARCHITECTURE='32 Bit'

#
# Check for x86_64 (Test 1) - some O/S's use the -i switch
#
if [ "`uname -i|grep x86_64`" == "x86_64" ]; then
	ARCHITECTURE='64 Bit'
fi

#
# Check for x86_64 (Test 2) - some OSs (ie. Gentoo) return Processor manufacturer
# 	rather than architecture with "uname -i"
#
if [ "`uname -a|grep x86_64`" != "" ]; then
	ARCHITECTURE='64 Bit'
fi


echo $ARCHITECTURE 'O/S detected.'

#Create conky skelaton
echo 'background yes
font Liberation:size=9
xftfont Sans Seriff:size=9
use_xft yes
xftalpha 0.1
update_interval 1.0
total_run_times 0
own_window yes
own_window_type override
own_window_transparent yes
own_window_hints undecorated,below,sticky,skip_taskbar,skip_pager
double_buffer yes
draw_shades yes
draw_outline no
draw_borders no
draw_graph_borders no
minimum_size 320 5
maximum_width 320
default_color ffff00
default_shade_color 000000
default_outline_color 000000
alignment top_right
gap_x 6
gap_y 22
no_buffers yes
cpu_avg_samples 2
override_utf8_locale no
uppercase no # set to yes if you want all text to be in uppercase
use_spacer no
' > ~/.conkyrc

#Count number of processor cores
CORES=1
CORES=`cat /proc/cpuinfo | grep "processor" | wc -l`
echo $CORES "Cpu core(s) Detected."
echo 'TEXT

'$HEADER'SYSTEM:${hr 1 }
'$BASE'O/S: '$HILIGHT'${alignr}Ultimate Edition 2.8
'$BASE'O/S architecture: '$HILIGHT'${alignr}'$ARCHITECTURE'
'$BASE'Hostname: '$HILIGHT'$alignr$nodename
'$BASE'Kernel: '$HILIGHT'$alignr$kernel
'$BASE'Uptime: '$HILIGHT'$alignr$uptime
'$BASE'Processes: '$HILIGHT'${alignr}$processes ($running_processes running)
'$BASE'Load: '$HILIGHT'${alignr}$loadavg
'$HEADER'CPU: ${hr 1 }
'$BASE$PROC'
'$BASE'CPU Usage: '$HILIGHT'${alignr} ${freq}MHz X '$CORES $BASE'
${cpu cpu0}% '$BAR' ${alignr}${cpubar cpu0 3,170}
'$HEADER'${hr 1}'$BASE'
'$BASE'Cores:' >> ~/.conkyrc

#Create a cpubar for each core
COUNTER=0
         while [  $COUNTER != $CORES ]; do
		let COUNTER=COUNTER+1 
		echo $BASE'${cpu cpu'$COUNTER'}% '$BAR'${alignr}${cpubar cpu'$COUNTER' 3,170}' >> ~/.conkyrc
         done

#Output disk I/O bar top processes memory useage etc.
echo $HEADER'RAM:${hr 1 }'$HILIGHT'
${alignr}$mem / $memmax ($memperc%)'$HILIGHT'
'$BAR'${membar 3}
'$BASE'Swap: '$HILIGHT'${alignr}$swap/$swapmax
'$BAR'${swapbar 3}
'$HEADER'${font pixelsize=20}${alignc}Time: ${time %I:%M %P}
'$HEADER'HIGHEST CPU $alignr CPU% MEM%
${hr 1}
'$BASE'${top name 1}'$HILIGHT'$alignr${top cpu 1}${top mem 1}
'$BASE'${top name 2}'$HILIGHT'$alignr${top cpu 2}${top mem 2}
'$HEADER'${hr 1}
HIGHEST MEM $alignr CPU% MEM%
${hr 1}
'$BASE'${top_mem name 1}'$HILIGHT'$alignr${top_mem cpu 1}${top_mem mem 1}
'$BASE'${top_mem name 2}$alignr'$HILIGHT'${top_mem cpu 2}${top_mem mem 2}
'$HEADER'DISK I/O: ${diskio}
'$BAR'${diskiograph /dev/sda 3,170}
'$HEADER'FILESYSTEM ${hr 1}
'$BASE'Root: '$HILIGHT'${alignr}${fs_free /} / ${fs_size /}
'$BAR'${fs_bar 3 /}' >> ~/.conkyrc

#Detect hard disks & create a bar for each mount point
echo "Internal / External storage detected:"
echo "/ - Root" 
ls /media/ > /tmp/tmp.txt
cat /tmp/tmp.txt | while read FILE
do
target=$(echo "$FILE" | sed -e "s/ /_/")
echo $BASE$FILE': '$HILIGHT'${alignr}${fs_free /media/'$FILE'} / ${fs_size /media/'$FILE'}
'$BAR'${fs_bar 3 /media/'$FILE'}' >> ~/.conkyrc
echo $FILE
done
rm /tmp/tmp.txt
echo $HEADER'NETWORK:${hr 1}' >> ~/.conkyrc

#Detect "Active" network and propigate Network Xfer bar
ACTIVE=`ifconfig | grep -B 1 inet | head -1 | awk '{print $1}'`
echo $BASE'IP: '$HILIGHT'${addr '$ACTIVE'} / ${execi 3600 wget -O - http://whatismyip.org/ | tail}
'$BASE'TCP Connections: '$HILIGHT'${tcp_portmon 1 65535 count}
'$BASE'Down: '$HILIGHT'${downspeed '$ACTIVE'} k/s ${alignr}Up ${upspeed '$ACTIVE'} k/s
'$BAR'${downspeedgraph '$ACTIVE' 25,107 '$BASE' '$HILIGHT'} ${alignr}${upspeedgraph '$ACTIVE' 25,107 '$BASE' '$HILIGHT'}
'$BASE'Total: '$HILIGHT'${totaldown '$ACTIVE'} ${alignr}'$BASE'Total: '$HILIGHT'${totalup '$ACTIVE'}' >> ~/.conkyrc
echo $HEADER'${hr 1}' >> ~/.conkyrc

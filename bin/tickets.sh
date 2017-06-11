#!/bin/bash 
_BOXURL=$ROUTER_URL
_PASSWORD=$ROUTER_PWD
_CHALLENGE=$(curl -s ${_BOXURL}/|grep '"challenge":'|sed 's/.*"challenge":"\([^"]*\)".*/\1/')
_MD5=$(echo -n ${_CHALLENGE}"-"${_PASSWORD} | iconv -f ISO8859-1 -t UTF-16LE | md5sum -b | awk '{print substr($0,1,32)}') 
_RESPONSE=${_CHALLENGE}"-"${_MD5} 
_SID=$(curl -i -s -k -d 'response='${_RESPONSE} -d 'lp=' -d "username=" "${_BOXURL}/index.lua"|grep '\.lua?sid='|head -n1|sed 's/.*\.lua?sid=\([a-f0-9]*\)&.*/\1/')
_TICKETS=$(curl -s "${_BOXURL}/internet/pp_ticket.lua?sid=${_SID}")
echo $_TICKETS

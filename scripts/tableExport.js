function tableExport(selector,type){$('#'+selector).tableExport({type:type,separator:';',});}
(function($){$.fn.extend({tableExport:function(options){var defaults={separator:',',ignoreColumn:[],tableName:$(this).attr('id'),type:'csv',pdfFontSize:7,pdfLeftMargin:5,escape:'false',htmlContent:'false',consoleLog:'false'};var options=$.extend(defaults,options);var el=this;if(defaults.type=='csv'||defaults.type=='txt'){var tdData="";$(el).find('thead').find('tr').each(function(){tdData+="\n";$(this).filter(':visible').find('th').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){tdData+='"'+parseString($(this))+'"'+defaults.separator;}}});tdData=$.trim(tdData);tdData=$.trim(tdData).substring(0,tdData.length-1);});$(el).find('tbody').find('tr').each(function(){tdData+="\n";$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){tdData+='"'+parseString($(this))+'"'+defaults.separator;}}});tdData=$.trim(tdData).substring(0,tdData.length-1);});if(defaults.consoleLog=='true'){console.log(tdData);}
var base64data="base64,"+$.base64.encode(tdData);window.open('data:application/'+defaults.type+';filename=exportData;'+base64data);}else if(defaults.type=='sql'){var tdData="INSERT INTO `"+defaults.tableName+"` (";$(el).find('thead').find('tr').each(function(){$(this).filter(':visible').find('th').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){tdData+='`'+parseString($(this))+'`,';}}});tdData=$.trim(tdData);tdData=$.trim(tdData).substring(0,tdData.length-1);});tdData+=") VALUES ";$(el).find('tbody').find('tr').each(function(){tdData+="(";$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){tdData+='"'+parseString($(this))+'",';}}});tdData=$.trim(tdData).substring(0,tdData.length-1);tdData+="),";});tdData=$.trim(tdData).substring(0,tdData.length-1);tdData+=";";if(defaults.consoleLog=='true'){console.log(tdData);}
var base64data="base64,"+$.base64.encode(tdData);window.open('data:application/sql;filename=exportData;'+base64data);}else if(defaults.type=='json'){var jsonHeaderArray=[];$(el).find('thead').find('tr').each(function(){var tdData="";var jsonArrayTd=[];$(this).filter(':visible').find('th').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){jsonArrayTd.push(parseString($(this)));}}});jsonHeaderArray.push(jsonArrayTd);});var jsonArray=[];$(el).find('tbody').find('tr').each(function(){var tdData="";var jsonArrayTd=[];$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){jsonArrayTd.push(parseString($(this)));}}});jsonArray.push(jsonArrayTd);});var jsonFooterArray=[];$(el).find('tfoot').find('tr').each(function(){var tdData="";var jsonArrayTd=[];$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){jsonArrayTd.push(parseString($(this)));}}});jsonFooterArray.push(jsonArrayTd);});var jsonExportArray=[];jsonExportArray.push({header:jsonHeaderArray,data:jsonArray,footer:jsonFooterArray});if(defaults.consoleLog=='true'){console.log(JSON.stringify(jsonExportArray));}
var base64data="base64,"+$.base64.encode(JSON.stringify(jsonExportArray));window.open('data:application/json;filename=exportData;'+base64data);}else if(defaults.type=='xml'){var xml='<?xml version="1.0" encoding="utf-8"?>';xml+='<tabledata><fields>';$(el).find('thead').find('tr').each(function(){$(this).filter(':visible').find('th').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){xml+="<field>"+parseString($(this))+"</field>";}}});});xml+='</fields><data>';var rowCount=1;$(el).find('tbody').find('tr').each(function(){xml+='<row id="'+rowCount+'">';var colCount=0;$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){xml+="<column-"+colCount+">"+parseString($(this))+"</column-"+colCount+">";}}
colCount++;});rowCount++;xml+='</row>';});xml+='</data></tabledata>'
if(defaults.consoleLog=='true'){console.log(xml);}
var base64data="base64,"+$.base64.encode(xml);window.open('data:application/xml;filename=exportData;'+base64data);}else if(defaults.type=='excel'||defaults.type=='doc'||defaults.type=='powerpoint'){var excel="<table>";$(el).find('thead').find('tr').each(function(){excel+="<tr>";$(this).filter(':visible').find('th').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){excel+="<td>"+parseString($(this))+"</td>";}}});excel+='</tr>';});var rowCount=1;$(el).find('tbody').find('tr').each(function(){excel+="<tr>";var colCount=0;$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){excel+="<td>"+parseString($(this))+"</td>";}}
colCount++;});rowCount++;excel+='</tr>';});excel+='</table>'
if(defaults.consoleLog=='true'){console.log(excel);}
var excelFile="<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:"+defaults.type+"' xmlns='http://www.w3.org/TR/REC-html40'>";excelFile+="<head>";excelFile+="<!--[if gte mso 9]>";excelFile+="<xml>";excelFile+="<x:ExcelWorkbook>";excelFile+="<x:ExcelWorksheets>";excelFile+="<x:ExcelWorksheet>";excelFile+="<x:Name>";excelFile+="{worksheet}";excelFile+="</x:Name>";excelFile+="<x:WorksheetOptions>";excelFile+="<x:DisplayGridlines/>";excelFile+="</x:WorksheetOptions>";excelFile+="</x:ExcelWorksheet>";excelFile+="</x:ExcelWorksheets>";excelFile+="</x:ExcelWorkbook>";excelFile+="</xml>";excelFile+="<![endif]-->";excelFile+="</head>";excelFile+="<body>";excelFile+=excel;excelFile+="</body>";excelFile+="</html>";var base64data="base64,"+$.base64.encode(excelFile);window.open('data:application/vnd.ms-'+defaults.type+';filename=exportData.doc;'+base64data);}else if(defaults.type=='png'){html2canvas($(el),{onrendered:function(canvas){var img=canvas.toDataURL("image/png");window.open(img);}});}else if(defaults.type=='pdf'){var doc=new jsPDF('p','pt','a4',true);doc.setFontSize(defaults.pdfFontSize);var startColPosition=defaults.pdfLeftMargin;$(el).find('thead').find('tr').each(function(){$(this).filter(':visible').find('th').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){var colPosition=startColPosition+(index*50);doc.text(colPosition,20,parseString($(this)));}}});});var startRowPosition=20;var page=1;var rowPosition=0;$(el).find('tbody').find('tr').each(function(index,data){rowCalc=index+1;if(rowCalc%26==0){doc.addPage();page++;startRowPosition=startRowPosition+10;}
rowPosition=(startRowPosition+(rowCalc*10))-((page-1)*280);$(this).filter(':visible').find('td').each(function(index,data){if($(this).css('display')!='none'){if(defaults.ignoreColumn.indexOf(index)==-1){var colPosition=startColPosition+(index*50);doc.text(colPosition,rowPosition,parseString($(this)));}}});});doc.output('datauri');}
function parseString(data){if(defaults.htmlContent=='true'){content_data=data.html().trim();}else{content_data=data.text().trim();}
if(defaults.escape=='true'){content_data=escape(content_data);}
return content_data;}}});})(jQuery);var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(input){var output="";var chr1,chr2,chr3,enc1,enc2,enc3,enc4;var i=0;input=Base64._utf8_encode(input);while(i<input.length){chr1=input.charCodeAt(i++);chr2=input.charCodeAt(i++);chr3=input.charCodeAt(i++);enc1=chr1>>2;enc2=((chr1&3)<<4)|(chr2>>4);enc3=((chr2&15)<<2)|(chr3>>6);enc4=chr3&63;if(isNaN(chr2)){enc3=enc4=64;}else if(isNaN(chr3)){enc4=64;}
output=output+
this._keyStr.charAt(enc1)+this._keyStr.charAt(enc2)+
this._keyStr.charAt(enc3)+this._keyStr.charAt(enc4);}
return output;},decode:function(input){var output="";var chr1,chr2,chr3;var enc1,enc2,enc3,enc4;var i=0;input=input.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(i<input.length){enc1=this._keyStr.indexOf(input.charAt(i++));enc2=this._keyStr.indexOf(input.charAt(i++));enc3=this._keyStr.indexOf(input.charAt(i++));enc4=this._keyStr.indexOf(input.charAt(i++));chr1=(enc1<<2)|(enc2>>4);chr2=((enc2&15)<<4)|(enc3>>2);chr3=((enc3&3)<<6)|enc4;output=output+String.fromCharCode(chr1);if(enc3!=64){output=output+String.fromCharCode(chr2);}
if(enc4!=64){output=output+String.fromCharCode(chr3);}}
output=Base64._utf8_decode(output);return output;},_utf8_encode:function(string){string=string.replace(/\r\n/g,"\n");var utftext="";for(var n=0;n<string.length;n++){var c=string.charCodeAt(n);if(c<128){utftext+=String.fromCharCode(c);}
else if((c>127)&&(c<2048)){utftext+=String.fromCharCode((c>>6)|192);utftext+=String.fromCharCode((c&63)|128);}
else{utftext+=String.fromCharCode((c>>12)|224);utftext+=String.fromCharCode(((c>>6)&63)|128);utftext+=String.fromCharCode((c&63)|128);}}
return utftext;},_utf8_decode:function(utftext){var string="";var i=0;var c=c1=c2=0;while(i<utftext.length){c=utftext.charCodeAt(i);if(c<128){string+=String.fromCharCode(c);i++;}
else if((c>191)&&(c<224)){c2=utftext.charCodeAt(i+1);string+=String.fromCharCode(((c&31)<<6)|(c2&63));i+=2;}
else{c2=utftext.charCodeAt(i+1);c3=utftext.charCodeAt(i+2);string+=String.fromCharCode(((c&15)<<12)|((c2&63)<<6)|(c3&63));i+=3;}}
return string;}}
jQuery.base64=(function($){var _PADCHAR="=",_ALPHA="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",_VERSION="1.0";function _getbyte64(s,i){var idx=_ALPHA.indexOf(s.charAt(i));if(idx===-1){throw"Cannot decode base64";}
return idx;}
function _decode(s){var pads=0,i,b10,imax=s.length,x=[];s=String(s);if(imax===0){return s;}
if(imax%4!==0){throw"Cannot decode base64";}
if(s.charAt(imax-1)===_PADCHAR){pads=1;if(s.charAt(imax-2)===_PADCHAR){pads=2;}
imax-=4;}
for(i=0;i<imax;i+=4){b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12)|(_getbyte64(s,i+2)<<6)|_getbyte64(s,i+3);x.push(String.fromCharCode(b10>>16,(b10>>8)&0xff,b10&0xff));}
switch(pads){case 1:b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12)|(_getbyte64(s,i+2)<<6);x.push(String.fromCharCode(b10>>16,(b10>>8)&0xff));break;case 2:b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12);x.push(String.fromCharCode(b10>>16));break;}
return x.join("");}
function _getbyte(s,i){var x=s.charCodeAt(i);if(x>255){throw"INVALID_CHARACTER_ERR: DOM Exception 5";}
return x;}
function _encode(s){if(arguments.length!==1){throw"SyntaxError: exactly one argument required";}
s=String(s);var i,b10,x=[],imax=s.length-s.length%3;if(s.length===0){return s;}
for(i=0;i<imax;i+=3){b10=(_getbyte(s,i)<<16)|(_getbyte(s,i+1)<<8)|_getbyte(s,i+2);x.push(_ALPHA.charAt(b10>>18));x.push(_ALPHA.charAt((b10>>12)&0x3F));x.push(_ALPHA.charAt((b10>>6)&0x3f));x.push(_ALPHA.charAt(b10&0x3f));}
switch(s.length-imax){case 1:b10=_getbyte(s,i)<<16;x.push(_ALPHA.charAt(b10>>18)+_ALPHA.charAt((b10>>12)&0x3F)+_PADCHAR+_PADCHAR);break;case 2:b10=(_getbyte(s,i)<<16)|(_getbyte(s,i+1)<<8);x.push(_ALPHA.charAt(b10>>18)+_ALPHA.charAt((b10>>12)&0x3F)+_ALPHA.charAt((b10>>6)&0x3f)+_PADCHAR);break;}
return x.join("");}
return{decode:_decode,encode:_encode,VERSION:_VERSION};}(jQuery));var jsPDF=function(){var version='20090504';var buffer='';var pdfVersion='1.3';var defaultPageFormat='a4';var pageFormats={'a3':[841.89,1190.55],'a4':[595.28,841.89],'a5':[420.94,595.28],'letter':[612,792],'legal':[612,1008]};var textColor='0 g';var page=0;var objectNumber=2;var state=0;var pages=new Array();var offsets=new Array();var lineWidth=0.200025;var pageHeight;var k;var unit='mm';var fontNumber;var documentProperties={};var fontSize=7;var pageFontSize=7;if(unit=='pt'){k=1;}else if(unit=='mm'){k=72/25.4;}else if(unit=='cm'){k=72/2.54;}else if(unit=='in'){k=72;}
var newObject=function(){objectNumber++;offsets[objectNumber]=buffer.length;out(objectNumber+' 0 obj');}
var putHeader=function(){out('%PDF-'+pdfVersion);}
var putPages=function(){var wPt=pageWidth*k;var hPt=pageHeight*k;for(n=1;n<=page;n++){newObject();out('<</Type /Page');out('/Parent 1 0 R');out('/Resources 2 0 R');out('/Contents '+(objectNumber+1)+' 0 R>>');out('endobj');p=pages[n];newObject();out('<</Length '+p.length+'>>');putStream(p);out('endobj');}
offsets[1]=buffer.length;out('1 0 obj');out('<</Type /Pages');var kids='/Kids [';for(i=0;i<page;i++){kids+=(3+2*i)+' 0 R ';}
out(kids+']');out('/Count '+page);out(sprintf('/MediaBox [0 0 %.2f %.2f]',wPt,hPt));out('>>');out('endobj');}
var putStream=function(str){out('stream');out(str);out('endstream');}
var putResources=function(){putFonts();putImages();offsets[2]=buffer.length;out('2 0 obj');out('<<');putResourceDictionary();out('>>');out('endobj');}
var putFonts=function(){newObject();fontNumber=objectNumber;name='Helvetica';out('<</Type /Font');out('/BaseFont /'+name);out('/Subtype /Type1');out('/Encoding /WinAnsiEncoding');out('>>');out('endobj');}
var putImages=function(){}
var putResourceDictionary=function(){out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');out('/Font <<');out('/F1 '+fontNumber+' 0 R');out('>>');out('/XObject <<');putXobjectDict();out('>>');}
var putXobjectDict=function(){}
var putInfo=function(){out('/Producer (jsPDF '+version+')');if(documentProperties.title!=undefined){out('/Title ('+pdfEscape(documentProperties.title)+')');}
if(documentProperties.subject!=undefined){out('/Subject ('+pdfEscape(documentProperties.subject)+')');}
if(documentProperties.author!=undefined){out('/Author ('+pdfEscape(documentProperties.author)+')');}
if(documentProperties.keywords!=undefined){out('/Keywords ('+pdfEscape(documentProperties.keywords)+')');}
if(documentProperties.creator!=undefined){out('/Creator ('+pdfEscape(documentProperties.creator)+')');}
var created=new Date();var year=created.getFullYear();var month=(created.getMonth()+1);var day=created.getDate();var hour=created.getHours();var minute=created.getMinutes();var second=created.getSeconds();out('/CreationDate (D:'+sprintf('%02d%02d%02d%02d%02d%02d',year,month,day,hour,minute,second)+')');}
var putCatalog=function(){out('/Type /Catalog');out('/Pages 1 0 R');out('/OpenAction [3 0 R /FitH null]');out('/PageLayout /OneColumn');}
function putTrailer(){out('/Size '+(objectNumber+1));out('/Root '+objectNumber+' 0 R');out('/Info '+(objectNumber-1)+' 0 R');}
var endDocument=function(){state=1;putHeader();putPages();putResources();newObject();out('<<');putInfo();out('>>');out('endobj');newObject();out('<<');putCatalog();out('>>');out('endobj');var o=buffer.length;out('xref');out('0 '+(objectNumber+1));out('0000000000 65535 f ');for(var i=1;i<=objectNumber;i++){out(sprintf('%010d 00000 n ',offsets[i]));}
out('trailer');out('<<');putTrailer();out('>>');out('startxref');out(o);out('%%EOF');state=3;}
var beginPage=function(){page++;state=2;pages[page]='';pageHeight=pageFormats['a4'][1]/k;pageWidth=pageFormats['a4'][0]/k;}
var out=function(string){if(state==2){pages[page]+=string+'\n';}else{buffer+=string+'\n';}}
var _addPage=function(){beginPage();out(sprintf('%.2f w',(lineWidth*k)));pageFontSize=fontSize;out('BT /F1 '+parseInt(fontSize)+'.00 Tf ET');}
_addPage();var pdfEscape=function(text){return text.replace(/\\/g,'\\\\').replace(/\(/g,'\\(').replace(/\)/g,'\\)');}
return{addPage:function(){_addPage();},text:function(x,y,text){if(pageFontSize!=fontSize){out('BT /F1 '+parseInt(fontSize)+'.00 Tf ET');pageFontSize=fontSize;}
var str=sprintf('BT %.2f %.2f Td (%s) Tj ET',x*k,(pageHeight-y)*k,pdfEscape(text));out(str);},setProperties:function(properties){documentProperties=properties;},addImage:function(imageData,format,x,y,w,h){},output:function(type,options){endDocument();if(type==undefined){return buffer;}
if(type=='datauri'){document.location.href='data:application/pdf;base64,'+Base64.encode(buffer);}},setFontSize:function(size){fontSize=size;}}};function sprintf(){var regex=/%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;var a=arguments,i=0,format=a[i++];var pad=function(str,len,chr,leftJustify){if(!chr)chr=' ';var padding=(str.length>=len)?'':Array(1+len-str.length>>>0).join(chr);return leftJustify?str+padding:padding+str;};var justify=function(value,prefix,leftJustify,minWidth,zeroPad,customPadChar){var diff=minWidth-value.length;if(diff>0){if(leftJustify||!zeroPad){value=pad(value,minWidth,customPadChar,leftJustify);}else{value=value.slice(0,prefix.length)+pad('',diff,'0',true)+value.slice(prefix.length);}}
return value;};var formatBaseX=function(value,base,prefix,leftJustify,minWidth,precision,zeroPad){var number=value>>>0;prefix=prefix&&number&&{'2':'0b','8':'0','16':'0x'}[base]||'';value=prefix+pad(number.toString(base),precision||0,'0',false);return justify(value,prefix,leftJustify,minWidth,zeroPad);};var formatString=function(value,leftJustify,minWidth,precision,zeroPad,customPadChar){if(precision!=null){value=value.slice(0,precision);}
return justify(value,'',leftJustify,minWidth,zeroPad,customPadChar);};var doFormat=function(substring,valueIndex,flags,minWidth,_,precision,type){var number;var prefix;var method;var textTransform;var value;if(substring=='%%')return'%';var leftJustify=false,positivePrefix='',zeroPad=false,prefixBaseX=false,customPadChar=' ';var flagsl=flags.length;for(var j=0;flags&&j<flagsl;j++)switch(flags.charAt(j)){case' ':positivePrefix=' ';break;case'+':positivePrefix='+';break;case'-':leftJustify=true;break;case"'":customPadChar=flags.charAt(j+1);break;case'0':zeroPad=true;break;case'#':prefixBaseX=true;break;}
if(!minWidth){minWidth=0;}else if(minWidth=='*'){minWidth=+a[i++];}else if(minWidth.charAt(0)=='*'){minWidth=+a[minWidth.slice(1,-1)];}else{minWidth=+minWidth;}
if(minWidth<0){minWidth=-minWidth;leftJustify=true;}
if(!isFinite(minWidth)){throw new Error('sprintf: (minimum-)width must be finite');}
if(!precision){precision='fFeE'.indexOf(type)>-1?6:(type=='d')?0:void(0);}else if(precision=='*'){precision=+a[i++];}else if(precision.charAt(0)=='*'){precision=+a[precision.slice(1,-1)];}else{precision=+precision;}
value=valueIndex?a[valueIndex.slice(0,-1)]:a[i++];switch(type){case's':return formatString(String(value),leftJustify,minWidth,precision,zeroPad,customPadChar);case'c':return formatString(String.fromCharCode(+value),leftJustify,minWidth,precision,zeroPad);case'b':return formatBaseX(value,2,prefixBaseX,leftJustify,minWidth,precision,zeroPad);case'o':return formatBaseX(value,8,prefixBaseX,leftJustify,minWidth,precision,zeroPad);case'x':return formatBaseX(value,16,prefixBaseX,leftJustify,minWidth,precision,zeroPad);case'X':return formatBaseX(value,16,prefixBaseX,leftJustify,minWidth,precision,zeroPad).toUpperCase();case'u':return formatBaseX(value,10,prefixBaseX,leftJustify,minWidth,precision,zeroPad);case'i':case'd':{number=parseInt(+value);prefix=number<0?'-':positivePrefix;value=prefix+pad(String(Math.abs(number)),precision,'0',false);return justify(value,prefix,leftJustify,minWidth,zeroPad);}
case'e':case'E':case'f':case'F':case'g':case'G':{number=+value;prefix=number<0?'-':positivePrefix;method=['toExponential','toFixed','toPrecision']['efg'.indexOf(type.toLowerCase())];textTransform=['toString','toUpperCase']['eEfFgG'.indexOf(type)%2];value=prefix+Math.abs(number)[method](precision);return justify(value,prefix,leftJustify,minWidth,zeroPad)[textTransform]();}
default:return substring;}};return format.replace(regex,doFormat);}
﻿window.jsPDF = window.jspdf.jsPDF;
var callAddFont = function () {
this.addFileToVFS('Koruri-normal.ttf', font);
this.addFont('Koruri-normal.ttf', 'Koruri', 'normal');
};
jsPDF.API.events.push(['addFonts', callAddFont])
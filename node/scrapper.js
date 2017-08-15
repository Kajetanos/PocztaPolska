
var express = require('express');
var request = require('request'), 
    cheerio = require('cheerio'),
    fs      = require('fs');
var app     = express();
    
    
//  app.get('/scrape', function(req, res){

    url  = 'http://cennik.poczta-polska.pl/usluga,zagraniczny_paczka_pocztowa.html';
    
    
    request ( url , function (err , res , body ) {
        
//        if(!err && res.statusCode === 200){
           var $ = cheerio.load(body);
               var PriceObj = {};
//           var type=typ;
           $('div.ceny > span.cena').each(function(){
               var price = $(this);
               var classes = price.attr('class');
               

                
                var n = classes.replace(/hidden|cena|wybor_/g, '').trim().replace(/\s/g, ',');
                PriceObj[n] = price.html();
                
//                console.log(PriceObj); // tutaj mam tablice z indeksami 
           });
        
         var jsonString = JSON.stringify(PriceObj);
  fs.writeFile('../public/poczta/output.json',jsonString,  function(err){
	    	if (err)
                    return console.log(err);
                console.log('PriceObj > ../public/poczta/output.json');
    });
//        }
//    res.send('Scraping Done...');
         
        
//        var jsonString = JSON.stringify(PriceObj);
//            
//            var filename=link.replace(/usluga,|krajowy_|zagraniczny_|.html/g,'');
//
//            fs.writeFile('../public/poczta/cennik_'+filename+'.json', jsonString, function (err) {
//                if (err)
//                    return console.log(err);
//                console.log('PriceObj > Poczta/Cennik/'+type+'/cennik_'+filename+'.json');
//            });
        
  
    });
   
 
  
//  });
    
//    app.listen('8002');
//    
//    console.log('Your node server start successfully....');
//
//exports = module.exports = app;
//                fs.writeFile('../public/output.json', JSON.stringify(PriceObj, null, 4), function(err){
//	    	console.log('Sraping data successfully written! - Check your project public/output.json file');
//		});
//            }
//        });
//  });


//var request = require("request");
//var cheerio = require("cheerio");
//var fs = require('fs');
//
//var uslugiLinks = {
//    Krajowe: [
//        'usluga,krajowy_przesylka_polecona.html',
//        'usluga,krajowy_przesylka_listowa_nierejestrowana.html',
//        'usluga,krajowy_paczka_pocztowa.html'
//    ],
//    Zagraniczne: [
//        'usluga,zagraniczny_global_expres.html',
//        'usluga,zagraniczny_przesylka_listowa.html',
//        'usluga,zagraniczny_przesylka_listowa_polecona.html',
//        'usluga,zagraniczny_paczka_pocztowa.html',
//        'usluga,zagraniczny_ems_przesylki_kurierskie.html'
//    ]
//};
//for(var typ in uslugiLinks){
//    uslugiLinks[typ].forEach(function (link, index) {
//        var type=typ;
//        request({
//            uri: "http://cennik.poczta-polska.pl/" + link
//        }, function (error, response, body) {
//            var $ = cheerio.load(body);
//
//            var PriceObj = {};
//            $("div.ceny > span.cena").each(function () {
//                var price = $(this);
//                var classes = price.attr('class');
//                console.log(classes)
//                var n = classes.replace(/hidden|cena|wybor_/g, '').trim().replace(/\s/g, ',');
//                PriceObj[n] = price.html();
//            });
//            var jsonString = JSON.stringify(PriceObj);
//            
//            var filename=link.replace(/usluga,|krajowy_|zagraniczny_|.html/g,'');
//
//            fs.writeFile('../public/poczta/cennik_'+filename+'.json', jsonString, function (err) {
//                if (err)
//                    return console.log(err);
//                console.log('PriceObj > Poczta/Cennik/'+type+'/cennik_'+filename+'.json');
//            });
//
//        });
//    });
//}
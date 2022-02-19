require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
var json;// var globale du json
var jsonEntreprise;
var jsonclient;
var main;

/* ------ MODAL DE SUPPRESSION ------ */
var resetSuppr= $('#btn_suppr').attr("href");
var resetEntreprise= $('#auditEntreprise').attr("href");
var resetQuestionnaireClient= $('#questionnaireClient').attr("href");
var resetLogoClient = $('#logoclient').attr('src');
$('#bodyclient').on( "click", ".modalSupress", function() {
    var id=$(this).attr("value");
    $('#btn_suppr').attr("href",$('#btn_suppr').attr("href")+id);
    $('#modalSuppression').removeClass('invisible');
});

$('.closeModalSuppression').on('click', function(e){
    $('#btn_suppr').attr("href",resetSuppr);
    $('#modalSuppression').addClass('invisible');
});
/* ------ MODAL VUE ------ */
$('#bodyclient').on( "click", ".modalVue", function() {
    var id=$(this).attr("value");
    const xhttp_current = new XMLHttpRequest();
    xhttp_current.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            json=JSON.parse(this.responseText);
            for (var i = 0; i < json.length; i++) {
                if(id == json[i].id_client){
                    var entreprise =json[i].entreprise_id.id_entreprise;
                    var client=json[i].id_client;
                    var logo = json[i].logo;
                    var nomClient=json[i].nom.split(' ');
                    // peut-être rajouter des labels, pour s'y retrouver
                    modal='<div class="mt-4"><input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none text-light" type="text" value="'+json[i].nom+'" disabled/></div><div class="mt-4"><input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none text-light" type="text" value='+json[i].mail+' disabled/></div><div class="mt-4"><input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none text-light" type="text" value='+json[i].telephone+' disabled/></div><div class="mt-4"><input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none text-light" type="text" value='+json[i].entreprise_id.nom_entreprise+' disabled/></div><div class="mt-4"></div>'
                }
            }
            $('#modalBody').html("");
            $('#modalBody').append(modal);
            //$('#modalView').removeClass('invisible');
            //$('#auditEntreprise').attr("href",$('#auditEntreprise').attr("href")+entreprise+"/"+client);
            $('#questionnaireClient').attr("action", $('#questionnaireClient').attr('action')+client);
            $('#logoclient').attr("src", $('#logoclient').attr('src')+logo);
            $('#auditEntreprise').attr("action",$('#auditEntreprise').attr("action")+entreprise);
            $('#idClient').attr("value", client);
            $('#idEntreprise').attr("value", entreprise);
            if(logo==null){
                $('#logoclient').addClass('hidden');
            }
        }
    };
    xhttp_current.open("GET", 'http://localhost:8000/client/json');
    xhttp_current.send();
});

$('.closeModalView').on('click', function(e){
    //$('#modalView').addClass('invisible');
    $('#auditEntreprise').attr("href",resetEntreprise);
    $('#questionnaireClient').attr("href",resetQuestionnaireClient);
    $('#logoclient').attr("src", resetLogoClient);
    $('#logoclient').removeClass('hidden');
});

/* ------ MODAL DU CREATE ------ */
$("#modalOpenCreate" ).click(function() {
    $('#modalCreate').removeClass('invisible');
});
$('.closeModalCreate').on('click', function(e){
    //remise à 0 des input du formulaire si clic sur annuler
    $('#modalCreate').addClass('invisible');
    $('#name').val("");
    $('#mail').val("");
    $('#telephone').val("");
    $('#raison_sociale').val("");
    $('#contact_principal').val("default");
    $('#entreprise').val("default");
    $('#createEntreprise').removeClass('invisible');
});
$('#entreprise').on('change', function() {
    if(this.value!='default'){
        $('#createEntreprise').addClass('hidden');
    }else if(this.value=='default'){
        $('#createEntreprise').removeClass('hidden');
    }
});

/* ------ Creation de questions (update et create) ------ */
var modal;
$('#btnAjoutQuestion').click(function(){
    var id=$(this).attr("value");
    modal='<div class="mt-4" id='+"questionReponse"+id+'><div class="flex justify-between d-flex align-items-end mt-2"><label class="block font-medium text-sm text-gray-700 font-extrabold">Question</label><a role="button" class="supressQuestion" value='+id+'><img class="w-1/2" src="http://localhost:8000/images/supprimer.png" alt="suppr"></a></div><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"question"+id+' name='+"question"+id+' placeholder="Question" autofocus /><label class="block font-medium text-sm text-gray-700 font-extrabold">Type de réponse attendue</label><div class="mt-2"><div class="mt-4"><input class="form-check-input input" type="radio" id="input" name='+"typereponse"+id+' value="input"><label for="input"><input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" placeholder="Réponse de type texte" disabled /></label></div><div class="mt-2"><input class="form-check-input radio" type="radio" id="radio" name='+"typereponse"+id+' value="radio" checked><label for="radio">Réponse de type oui / non</label></div><div id='+"typereponse"+id+' class=""><div class="flex justify-between"><div class="mr-2"><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"oui"+id+' name='+"oui"+id+' placeholder="Note du oui" autofocus /></div><div class="w-full"><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"preconisationoui"+id+' name='+"preconisationoui"+id+' placeholder="Préconisation" autofocus /></div></div><div class="flex justify-between"><div class="mr-2"><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"non"+id+' name='+"non"+id+' placeholder="Note du non" autofocus /></div><div class="w-full"><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"preconisationnon"+id+' name='+"preconisationnon"+id+' placeholder="Préconisation" autofocus /></div></div><div class="flex justify-between"><div class="mr-2"><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"autre"+id+' name='+"autre"+id+' placeholder="Note autre" autofocus /></div><div class="w-full"><input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='+"preconisationautre"+id+' name='+"preconisationautre"+id+' placeholder="Préconisation" autofocus /></div></div></div></div></div>'

    $('#questionsuivante').append(modal);
    id++;
    $('#btnAjoutQuestion').val(id);
});

/* ------ Suppression des questions dans le formulaire de création ------*/
$('.supressQuestion').click(function(){
    var id=$(this).attr("value");
    $("#questionReponse"+id).remove();
});
$('#questionsuivante').on( "click", ".supressQuestion", function() {
    var id=$(this).attr("value");
    $("#questionReponse"+id).remove();
});

/* ------ Suppression des questions dans le update ------ */
$('.supressQuestion').click(function(){
    var id=$(this).attr("value");

    const xhttp_current = new XMLHttpRequest();
    xhttp_current.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#questionReponse"+id).remove();
        }
    };
    xhttp_current.open("GET", 'http://localhost:8000/question/delete/'+id);
    xhttp_current.send();
});

/* ------ create et update questionnaire, masquage des préconisations si input texte select en réponse ------ */
$( ".radio" ).focus(function() {
    var id=$(this).attr("name");
    $('#'+id).removeClass('hidden');
});
$('.input').focus(function(){
    var id=$(this).attr("name");
    $('#'+id).addClass('hidden');
});
$('#questionsuivante').on( "focus", ".radio", function() {
    var id=$(this).attr("name");
    $('#'+id).removeClass('hidden');
});
$('#questionsuivante').on( "focus", ".input", function() {
    var id=$(this).attr("name");
    $('#'+id).addClass('hidden');
});

/* ------ filtre client actifs / en attente ------ */
$('#filtre').click(function(){
    var status=$('#filtre').is(':checked')
    if(status==true){
        $('.wait').addClass('hidden');
        $('.active').removeClass('hidden');
        $('#clientActive').addClass('underline');
        $('#clientActive').addClass('font-bold');
        $('#clientWaiting').removeClass('underline');
        $('#clientWaiting').removeClass('font-bold');
    }else {
        $('.wait').removeClass('hidden');
        $('.active').addClass('hidden');
        $('#clientActive').removeClass('underline');
        $('#clientActive').removeClass('font-bold');
        $('#clientWaiting').addClass('underline');
        $('#clientWaiting').addClass('font-bold');
    }
});
$('#displayAll').click(function(){
    $('.wait').removeClass('hidden');
    $('.active').removeClass('hidden');
    $('#clientActive').removeClass('underline');
    $('#clientActive').removeClass('font-bold');
    $('#clientWaiting').removeClass('underline');
    $('#clientWaiting').removeClass('font-bold')
});

// lien ou l'on se trouve en "surbrillance"
$(function() {
        var url = window.location.href;
        $(".menu a").each(function() {
            // checks if its the same on the address bar
            if (url == (this.href)) {
                $(this).closest("a").addClass("font-bold");
                $(this).closest("a").addClass("underline");
                $(this).closest("a").removeClass("text-decoration-none");
            }
        });
});

$(function(){
    const xhttp_current = new XMLHttpRequest();
    xhttp_current.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            jsonEntreprise=JSON.parse(this.responseText);
        }
    };
    xhttp_current.open("GET", 'http://localhost:8000/entreprises/json');
    xhttp_current.send();
});

$( "#searchPageClient" ).keyup(function(e) {
    $('#pageClient').html("");
    main ='<div class="row m-0"><div class="col-12"><div class="d-flex justify-content-start bluejob text-3xl font-bold">Résultat de recherche</div></div></div><div class="row w-full"><div class="col-12"><div class="bg-white-700 p-1 overflow-auto"><table class="table table-striped table-borderless"><thead><tr><th>Raison Sociale</th><th>Siège social</th><th></th></tr></thead><tbody>'
    var value=e.currentTarget.value.toUpperCase();
    for (var i = 0; i < jsonEntreprise.length; i++) {
        var entreprise = jsonEntreprise[i].nom_entreprise.toUpperCase();
        var position = entreprise.search(value);
        if(position >= 0){
            main+='<tr><td>'+jsonEntreprise[i].nom_entreprise+'</td><td>'+jsonEntreprise[i].adresse_entreprise+" "+jsonEntreprise[i].code_postal+" "+jsonEntreprise[i].ville+'</td><td><a href="http://localhost:8000/entreprise/show/'+jsonEntreprise[i].id_entreprise+'" type="button"><img class="h-10" src="http://localhost:8000/images/view.png" alt="view"></a></td></tr><tr style="height:10px"></tr>'
        }
    }
    main+='</tbody></table></div></div></div>'
    $('#pageClient').append(main);

    if (value=="") {
        // redirect to client, moins chiant que de faire une requete ajax pour rechopper les clients,
        // et le réafficher en re-faisant tout le <main> + remplacer le code de blade par celui de JS
        document.location.href="http://localhost:8000/client";
    }
});

$( "#searchPageDashboard" ).keyup(function(e) {
    $('#dashboard').html("");
    main ='<div class="row m-0"><div class="col-12"><div class="d-flex justify-content-start bluejob text-3xl font-bold">Résultat de recherche</div></div></div><div class="row w-full"><div class="col-12"><div class="bg-white-700 p-1 overflow-auto"><table class="table table-striped table-borderless"><thead><tr><th>Raison Sociale</th><th>Siège social</th><th></th></tr></thead><tbody>'
    var value=e.currentTarget.value.toUpperCase();
    for (var i = 0; i < jsonEntreprise.length; i++) {
        var entreprise = jsonEntreprise[i].nom_entreprise.toUpperCase();
        var position = entreprise.search(value);
        if(position >= 0){
            main+='<tr><td>'+jsonEntreprise[i].nom_entreprise+'</td><td>'+jsonEntreprise[i].adresse_entreprise+" "+jsonEntreprise[i].code_postal+" "+jsonEntreprise[i].ville+'</td><td><a href="http://localhost:8000/entreprise/show/'+jsonEntreprise[i].id_entreprise+'" type="button"><img class="h-10" src="http://localhost:8000/images/view.png" alt="view"></a></td></tr><tr style="height:10px"></tr>'
        }
    }
    main+='</tbody></table></div></div></div>'
    $('#dashboard').append(main);

    if (value=="") {
        // redirect to client, moins chiant que de faire une requete ajax pour rechopper les clients,
        // et le réafficher en re-faisant tout le <main> + remplacer le code de blade par celui de JS
        document.location.href="http://localhost:8000/dashboard";
    }
});

$( "#searchPageQuestionnaire" ).keyup(function(e) {
    $('#PageQuestionnaire').html("");
    main ='<div class="row m-0"><div class="col-12"><div class="d-flex justify-content-start bluejob text-3xl font-bold">Résultat de recherche</div></div></div><div class="row w-full"><div class="col-12"><div class="bg-white-700 p-1 overflow-auto"><table class="table table-striped table-borderless"><thead><tr><th>Raison Sociale</th><th>Siège social</th><th></th></tr></thead><tbody>'
    var value=e.currentTarget.value.toUpperCase();
    for (var i = 0; i < jsonEntreprise.length; i++) {
        var entreprise = jsonEntreprise[i].nom_entreprise.toUpperCase();
        var position = entreprise.search(value);
        if(position >= 0){
            main+='<tr><td>'+jsonEntreprise[i].nom_entreprise+'</td><td>'+jsonEntreprise[i].adresse_entreprise+" "+jsonEntreprise[i].code_postal+" "+jsonEntreprise[i].ville+'</td><td><a href="http://localhost:8000/entreprise/show/'+jsonEntreprise[i].id_entreprise+'" type="button"><img class="h-10" src="http://localhost:8000/images/view.png" alt="view"></a></td></tr><tr style="height:10px"></tr>'
        }
    }
    main+='</tbody></table></div></div></div>'
    $('#PageQuestionnaire').append(main);

    if (value=="") {
        // redirect to client, moins chiant que de faire une requete ajax pour rechopper les clients,
        // et le réafficher en re-faisant tout le <main> + remplacer le code de blade par celui de JS
        document.location.href="http://localhost:8000/questionnaire/listing";
    }
});

$('.download').click(function(){
    var table = []; // tableaud es datas
    var titre = []; // tableau entête
    var id;
    var row;
    var compteur =0;
    var idQuestionnaire = $(this).attr("questionnaire");
    var idClient = $(this).attr('client');

    const xhttp_current = new XMLHttpRequest();
    xhttp_current.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            jsonclient=JSON.parse(this.responseText);
            console.log(jsonclient);
            $.each(jsonclient, function(keyJson, object) {
                if (object.reponse && compteur == 0) {
                    titre.splice(2, 0, "Date de Réponse");
                    table.splice(2, 0, object.date_reponse);
                    compteur++;
                }
                if (object.nom_questionnaire) {
                    titre.push("Nom Questionnaire");
                    table.push(object.nom_questionnaire);
                }
                if (object.description) {
                    titre.push("Description Questionnaire");
                    table.push(object.description);
                }
                if (object.id_question) {
                    id = object.id_question;
                }
                if (object.question) {
                    titre.push("Question");
                    table.push(object.question);
                }
                if (object.reponse) {
                    titre.push("Réponse");
                    table.push(object.reponse);
                }
                if (keyJson == 'Preconisation'+id) {
                    titre.push("Note");
                    titre.push("Préconisation");
                    table.push(object.note_reponse);
                    table.push(object.conseil);
                }
            });

            var datas = table.join(";");
            var entete = titre.join(";");
            var csvContent = "data:text/csv;charset=utf-8,";
            csvContent += entete +"\r\n"+ datas + "\r\n";
            /* create a hidden <a> DOM node and set its download attribute */
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Questionnaire.csv");
            document.body.appendChild(link);
             /* download the data file */
            link.click();
        }
    };
    xhttp_current.open("GET", 'http://localhost:8000/questionnaire/jsonclient/'+idQuestionnaire+'/'+idClient);
    xhttp_current.send();
});

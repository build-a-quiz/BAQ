/*
 * send.js
 * General purpose javascript.
 * The quiz is entirely built in the browser-session via javascript.
 * This is done for the sake of not having fragments on the server.
 */

// global variables
let allQ = [];
let allU = [];

// function to send the question to the server
function send() {

    // get information about quiz and players
    let creator = document.getElementById('userid').value
    let players = allU.toString()
    let quizname = document.getElementById('quizname').value

    // generate new request
    let req = new XMLHttpRequest();
    req.open("POST", 'send.php');
    req.setRequestHeader("creator", creator);
    req.setRequestHeader("players", players);
    req.setRequestHeader('quizname', quizname);

    // send request to server
    req.send(JSON.stringify(allQ));
    console.log(allQ)

    if (quizname) {
        swal.fire({
            icon: 'success',
            title: "Quiz " + quizname + " wurde erfolgreich erstellt und in der Datenbank gespeichert",
            confirmButtonText: 'Alles klar!',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('quizname').value = ''
                location.reload()
            }
        })
    } else {
        swal.fire({
            icon: 'warning',
            title: "Es wurde kein Quizname vergeben!"
        })
    }
}
async function addUser(){
        const {value: user} = await Swal.fire({
            title: 'Bitte Username eingeben:',
            // icon: 'question',
            input: 'text',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Schreiben oder Abbrechen!'
                }
            }
        });

        allU.push(user)

        if(user){

            let playersTable = document.getElementById('players').innerHTML;
            document.getElementById('players').innerHTML=playersTable + "<tr><td>&bullet; " + user + "</td></tr>";
        }

        console.log(allU)
    }
async function addFreeText() {

    const {value: question} = await Swal.fire({
        title: 'Bitte Frage eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const {value: solution} = await Swal.fire({
        title: 'Bitte Antwort eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const {value: points} = await Swal.fire({
        title: 'Wie viel Punkte gibt es auf die Frage?',
        icon: 'question',
        input: 'range',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        inputValue: 1
    })

    // write question to temp array and print on preview
    if(question && solution && points) {
        allQ.push({"id":1,"type":"FreeText","question":question,"solution":solution,"points":points})
        console.log(allQ);

        // update preview div
        let preview = document.getElementById('preview').innerHTML;
        document.getElementById('preview').innerHTML=preview +"<br><br><hr><br>\
                <h4 class='display-8'>"+question+" ("+points+" Punkte)</h4>\
                <div class='col-xs-3'>\
                    <input class='form-control' id='x3' type='text' placeholder='Bitte Antwort hier eingeben...'>\
                </div>"
    }
}
async function addDropDown(){
    const {value: question} = await Swal.fire({
        title: 'Bitte DropDown-Frage eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const { value: answers } = await Swal.fire({
        title: 'Antwortmöglichkeiten definieren',
        html:
            '<input id="swal-input1" class="swal2-input">' +
            '<input id="swal-input2" class="swal2-input">'+
            '<input id="swal-input3" class="swal2-input">'+
            '<input id="swal-input4" class="swal2-input">',
            focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value
            ]
        }
    })

    let {value: solution} = await Swal.fire({
        title: answers,
        icon: 'question',
        input: 'text',
        inputLabel : 'Bitte richtige Antwort angeben:',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    // make answers lowercase
    let lowercaseAnswers = answers.map(ans => ans.toLowerCase())

    // get right answer
    solution = lowercaseAnswers.indexOf(solution.toLowerCase());

    const {value: points} = await Swal.fire({
        title: 'Wie viel Punkte gibt es auf die Frage?',
        icon: 'question',
        input: 'range',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        inputValue: 1
    })

    // write question to temp array and print on preview
    if(question && answers && solution >= 0 && points) {

        allQ.push({"id":1,"type":"DropDown","question":question,"answers":answers,"solution":solution,"points":points})
        console.log(allQ);

        // update preview div
        let preview = document.getElementById('preview').innerHTML;
        document.getElementById('preview').innerHTML=preview +"<br><br><hr><br>\
            <h4 class='display-8'>"+question+" ("+points+" Punkte)</h4>\
            <div class='col-xs-3'>\
            <select class='form-select' id='x3' aria-label='Bitte Antwort auswählen'>\
               <option>Bitte Antwort auswählen...</option>\
        </select>\
        </div>"
    }

}
async function addMultipleChoice(){

    const {value: question} = await Swal.fire({
        title: 'Bitte Multiple-Choice-Frage eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const { value: answers } = await Swal.fire({
        title: 'Antwortmöglichkeiten definieren',
        html:
            '<input id="swal-input1" class="swal2-input">' +
            '<input id="swal-input2" class="swal2-input">'+
            '<input id="swal-input3" class="swal2-input">'+
            '<input id="swal-input4" class="swal2-input">',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value
            ]
        }
    });

    let {value: solution} = await Swal.fire({
        title: answers,
        icon: 'question',
        input: 'text',
        inputLabel : 'Bitte richtige Antwort angeben:',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    let lowsercaseAnswers = answers.map(ans => ans.toLowerCase())
    solution = lowsercaseAnswers.indexOf(solution.toLowerCase());

    console.log(solution)


    const {value: points} = await Swal.fire({
        title: 'Wie viel Punkte gibt es auf die Frage?',
        icon: 'question',
        input: 'range',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        inputValue: 1
    });

    if(question && answers && solution >= 0 && points) {

        allQ.push({"id":1,"type":"MultipleChoice","question":question,"answers":answers,"solution":solution,"points":points})
        console.log(allQ);

        // update preview div
        let preview = document.getElementById('preview').innerHTML;
        document.getElementById('preview').innerHTML=preview +"<br><br><hr><br>\
                <h4 class='display-8'>"+question+" ("+points+" Punkte)</h4>\
                <div class='col-xs-3'>\
            <div class='form-check form-sclassName'>\
                <input class='form-check-input' type='radio'>\
                <label class='form-check-label'>Anwort-Möglichkeit</label>\
            </div>\
            <div class='form-check form-sclassName'>\
                <input class='form-check-input' type='radio'>\
                <label class='form-check-label'>Anwort-Möglichkeit</label>\
            </div>"
    }
}
async function addMultipleChoiceMA(){

    const {value: question} = await Swal.fire({
        title: 'Bitte Multiple-Choice-Frage eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const { value: answers } = await Swal.fire({
        title: 'Antwortmöglichkeiten definieren',
        html:
            '<input id="swal-input1" class="swal2-input">' +
            '<input id="swal-input2" class="swal2-input">'+
            '<input id="swal-input3" class="swal2-input">'+
            '<input id="swal-input4" class="swal2-input">',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value
            ]
        }
    });

    let lowercaseAnswers = answers.map(name => name.toLowerCase())

    console.log(lowercaseAnswers)

    let {value: solutions} = await Swal.fire({
        title: answers,

        html:
            '<b>Bitte die richtigen Lösungen angeben:</b>' +
            '<input id="swal-input1" class="swal2-input">' +
            '<input id="swal-input2" class="swal2-input">'+
            '<input id="swal-input3" class="swal2-input">'+
            '<input id="swal-input4" class="swal2-input">',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value
            ]
        }
    });

    let solNums =[]

    let lowercaseSolutions = solutions.map(sol => sol.toLowerCase())
    lowercaseSolutions.forEach(sol => {
        let num = lowercaseAnswers.indexOf(sol)
        if (num >= 0)
            solNums.push(num)
    })

    const {value: points} = await Swal.fire({
        title: 'Wie viel Punkte gibt es auf die Frage?',
        icon: 'question',
        input: 'range',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        inputValue: 1
    });

    if(question && answers && solNums && points) {

        allQ.push({"id":1,"type":"MultipleChoice","question":question,"answers":answers,"solution":solNums,"points":points})
        console.log(allQ);

        // update preview div
        let preview = document.getElementById('preview').innerHTML;
        document.getElementById('preview').innerHTML=preview +"<br><br><hr><br>\
                <h4 class='display-8'>"+question+" ("+points+" Punkte)</h4>\
                <div class='col-xs-3'>\
            <div class='form-check form-sclassName'>\
            <input class='form-check-input' type='checkbox' role='switch'>\
            <label class='form-check-label'>Anwort-Möglichkeit</label>\
            </div>\
            <div class='form-check form-sclassName'>\
            <input class='form-check-input' type='checkbox' role='switch'>\
            <label class='form-check-label'>Anwort-Möglichkeit</label>\
            </div>"
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: IGE OLUWASEGUN
 * Date: 11/11/2017
 * Time: 20:02
 */
Header("content-Type: application/javascript");
session_start();


 ?>

var vuedata=new Vue({
el: '#fetchQuestion',
data: {
availableOptions: ['A', 'B', 'C', 'D'],
Question: '',
questionIndex: 0,
userResponses: [],
showImage: "https://pass.ng/question_images/<?= strtolower($_SESSION['exam']) ?>/<?= strtolower($_SESSION['subject'])?>/",
selectedOptions: '',
logResponse: '',
answersChosen: [],
correctAns: [],
questionArray:[],
imageArray:[],
checked: '',
userResponsesSelectedOptions: [],
questionPage: true,
questionTotalPage:true,
QuestionNavigation:false,
optionAArray:[],
optionBArray:[],
optionCArray:[],
optionDArray:[],
TestNavigationQuestion:'',
TestNavigationOptionA:'',
TestNavigationOptionB:'',
TestNavigationOptionC:'',
TestNavigationOptionD:'',
selectedIndex:'',
TestNavigationImage:'',
NormalDisplay:true,
NavigationDisplay:false,
colorIndicator:[],
true_val:'',
false_val:'',
skipped_val:'',
scoreArray:[]
},
created: function () {
this.loadQuestions();
//                console.log('this is this:'+this);

},
methods: {
GoToIndex:function(selectedIndex){
<!--console.log('am now here');-->
if (this.selectedOptions[(this.questionIndex)]== 1 ){
this.colorIndicator[(this.questionIndex)]="grey";
}else{
this.colorIndicator[this.questionIndex]="red";
}

this.questionIndex=selectedIndex;
//                this.colorIndicator[this.questionIndex]="red";
this.TestNavigationQuestion=this.questionArray[selectedIndex];
this.TestNavigationOptionA=this.optionAArray[selectedIndex];
this.TestNavigationOptionB=this.optionBArray[selectedIndex];
this.TestNavigationOptionC=this.optionCArray[selectedIndex];
this.TestNavigationOptionD=this.optionDArray[selectedIndex];
this.TestNavigationImage=this.imageArray[selectedIndex];
this.NavigationDisplay=true;
this.NormalDisplay=false;
this.questionPage=false;
this.QuestionNavigation=true;
this.colorIndicator[this.questionIndex]="yellow";
//                console.log('this is the navigation display from GoToIndex:'+this.NavigationDisplay);
//                console.log('this is the normal display from GoToIndex:'+this.NormalDisplay);
},
loadQuestions: function () {
const question = this;
axios.get('/fetchexam').then(function (response) {
question.Question = response.data;
//                    console.log('this are the questions:'+response.data);
if (question.Question =="" || question.Question=="No question"){
alert('Oops! No content for this year. Kindly pick another year.');
window.location.href='/test' ;
}else{
//                            console.log(response.data.length);
}
/*shuffle the questions*/
question.randomiseQuestion(response.data);
//                            console.log('these are the shuffled questions:'+question.shuffled);
//                        lists all the correct options
for (var i = 0; i < response.data.length; i++) {
var allAnswers = response.data[i].optionans;
question.correctAns.push(allAnswers);

}

/*lists all the questions*/

for (var q=0; q< response.data.length; q++){
var allQuestions=response.data[q].question;
question.questionArray.push(allQuestions);
//                            question.questionArray.join('_');

}


/*list all options A*/
for (var opA=0; opA< response.data.length; opA++){
var allOptionA=response.data[opA].optiona;
question.optionAArray.push(allOptionA);
}
//                    console.log('this is option A:'+question.optionAArray);
/*list all options B*/
for (var opB=0; opB< response.data.length; opB++){
var allOptionB=response.data[opB].optionb;
question.optionBArray.push(allOptionB);
}
//                    console.log('this is option B:'+question.optionBArray);
//
//                    /*list all options C*/
for (var opC=0; opC< response.data.length; opC++){
var allOptionC=response.data[opC].optionc;
question.optionCArray.push(allOptionC);
}
//                    console.log('this is option C:'+question.optionCArray);
//                    /*list all options D*/
for (var opD=0; opD< response.data.length; opD++){
var allOptionD=response.data[opD].optiond;
question.optionDArray.push(allOptionD);
}



//                    console.log('this is option D:'+question.optionDArray);
//console.log('These are the questions:'+question.questionArray[0]);
/*lists of all images*/
for (var img=0; img<response.data.length; img++){
var allImages=response.data[img].image;
question.imageArray.push(allImages);
}
//                        console.log('these are the images:'+question.imageArray);
question.colorIndicator[(question.questionIndex)]="yellow";
//                        console.log(question.Question);
question.userResponses = Array(response.data.length).fill('skipped');
question.selectedOptions = Array(response.data.length).fill(0);
question.answersChosen = Array(response.data.length).fill(0);

})
.catch(function (error) {
question.Question = 'An error occurred ' + error;
})
},

score: function () {
/*return true count in userResponses*/
this.true_val=this.userResponsesSelectedOptions.reduce(function (n, val) {
return n + (val === true);
}, 0);
this.false_val=this.userResponsesSelectedOptions.reduce(function (n, val) {
return n + (val === false);
}, 0);

this.skipped_val=this.Question.length-(this.true_val+this.false_val);

//                 this.true_val+'_'+this.false_val+'_'+this.skipped_val;
this.scoreArray[0]=this.true_val;
this.scoreArray[1]=this.false_val;
this.scoreArray[2]=this.skipped_val;

return this.scoreArray[0];
},
previousQuestion: function () {
//                console.log('this is the normal display previousQuestion:'+this.NormalDisplay);
/*go to previous question*/
this.questionIndex--;
if (this.selectedOptions[(this.questionIndex)]==0 && this.NormalDisplay==false ){
this.colorIndicator[(this.questionIndex)]="red";

}

if (this.selectedOptions[(this.questionIndex+1)]==0){
this.colorIndicator[(this.questionIndex+1)]="red";

}

if (this.NormalDisplay==false){

}else{
this.NormalDisplay=true;
}
this.NavigationDisplay=false;

this.questionPage=true;
this.QuestionNavigation=false;
//                console.log('this is the normal display after conditions in previousQuestion:'+this.NormalDisplay);
//        console.log('this is the question Index:'+(this.questionIndex+1));
//
//                console.log('this is the question Index:'+(this.questionIndex));


if (this.questionIndex){
//                        console.log('true:'+this.questionIndex);
}else{
//                        console.log('false:'+this.questionIndex);
}


if (this.selectedOptions[(this.questionIndex+1)] == 1 ) {
//                            this.logResponse = 'Question has been attempted';
//                            console.log(this.logResponse);
//                    this.colorIndicator(this.questionIndex)="grey";

this.colorIndicator[(this.questionIndex+1)]="grey";
this.colorIndicator[this.questionIndex]="yellow";
} else {
//                            this.logResponse = 'Question not yet attempted';
//                            console.log(this.logResponse);

this.colorIndicator[this.questionIndex]="yellow";
}



},
nextQuestion: function () {

/*go to next question*/
this.questionIndex++;

//                console.log('this is the navigation display nextQuestion:'+this.NavigationDisplay);
if (this.selectedOptions[(this.questionIndex-1)]==0 && (this.NavigationDisplay==true || this.NavigationDisplay==false)){
this.colorIndicator[(this.questionIndex-1)]="red";
}



this.NavigationDisplay=false;
this.NormalDisplay=true;

this.questionPage=true;
this.QuestionNavigation=false;
//                console.log('this is the question Index:'+(this.questionIndex+1));
//                console.log('this is the question Index:'+(this.questionIndex));
//                if (this.selectedOptions[(this.questionIndex+1)]==0){
//                    this.colorIndicator[(this.questionIndex+1)]="red";
//
//
//                if (this.questionIndex){
//                    console.log('true:'+this.questionIndex);
//                }else{
//                    console.log('false:'+this.questionIndex);
//                }
if (this.selectedOptions[(this.questionIndex-1)] == 1 ) {
//                            this.logResponse = 'Question has been attempted';
//                            console.log(this.logResponse);

this.colorIndicator[(this.questionIndex-1)]="grey";
this.colorIndicator[this.questionIndex]="yellow";
} else {
//                            this.logResponse = 'Question not yet attempted';
//                            console.log(this.logResponse);
//                    this.colorIndicator[this.questionIndex]="yellow";
this.colorIndicator[this.questionIndex]="yellow";
}


},
isCorrect: function (selectedAnswer, correctAnswer, currentIndex) {

//                        console.log('This is the selected Answer:' + selectedAnswer + ' and this is the correct answer:' + correctAnswer + ' and this is the current Index:' + currentIndex);
if (selectedAnswer == correctAnswer) {
this.userResponses[currentIndex] = true;
this.userResponsesSelectedOptions[currentIndex] = true;
//                    console.log('yes, they are the same');
//                            console.log(this.userResponses);
//                            console.log('this is userResponse2:'+this.userResponses2);

} else {
this.userResponses[currentIndex] = false;
this.userResponsesSelectedOptions[currentIndex] = false;
//                    console.log('no,they are not the same');
//                            console.log(this.userResponses);
//                            console.log('this is userResponse2:'+this.userResponses2);
}

//                console.log('This is the current index:' + currentIndex);
this.selectedOptions[currentIndex] = 1;
//                        this.logResponse = 'Question has been attempted';
//                        console.log('These are the list of the questions:' + this.selectedOptions);
//                        console.log(this.logResponse);

if (this.selectedOptions[currentIndex] == 1) {
//                    Question had already been attempted
this.answersChosen[currentIndex] = selectedAnswer;
//                            console.log('This is the arrangement  of the chosen answers:' + this.answersChosen);

} else {
//                    Question not yet attempted

}
//                this.colorIndicator[this.questionIndex]="grey";

//                console.log('This is the user Response array:'+this.userResponses);
//                console.log('this is the current number of skipped questions:'+this.score());

},resetEverything:function(){
clearInterval(countdownTimer);
},submit: function () {
/*triggers a confirmation dialogBox*/
if (confirm("Are you sure ?") == true) {
this.questionTotalPage=false;
this.resetEverything();
document.getElementById('score').value=this.score();
document.getElementById('questionLength').value=this.Question.length;
document.getElementById('questionArrayhid').value=this.questionArray.join('`');
document.getElementById('optionAArrayhid').value=this.optionAArray.join('`');
document.getElementById('optionBArrayhid').value=this.optionBArray.join('`');
document.getElementById('optionCArrayhid').value=this.optionCArray.join('`');
document.getElementById('optionDArrayhid').value=this.optionDArray.join('`');
document.getElementById('answersChosenhid').value=this.answersChosen;
document.getElementById('correctAnshid').value=this.correctAns;
//console.log('this is the questionArrayhid:'+document.getElementById('questionArrayhid').value);
//                        console.log('this is the question length'+document.getElementById('answersChosenhid').value);
//                        window.location.href='#';
document.forms["test-taken"].submit();


} else {
}
},
randomiseQuestion: function (array) {
for (var i = array.length - 1; i > 0; i--) {
var j = Math.floor(Math.random() * (i + 1));
[array[i], array[j]] = [array[j], array[i]];
}
return array;
}

}

});


var seconds = 60*<?=$_SESSION['time']?>;
function secondPassed() {
var minutes = Math.round((seconds - 30)/60);
var remainingSeconds = seconds % 60;
if (remainingSeconds < 10) {
remainingSeconds = "0" + remainingSeconds;
}
document.getElementById('countdown').innerHTML = minutes + ":" +    remainingSeconds;
if (seconds == 0) {
clearInterval(countdownTimer);
document.getElementById('score').value=vuedata.score();
document.getElementById('questionLength').value=vuedata.Question.length;
document.getElementById('questionArrayhid').value=vuedata.questionArray.join('`');
document.getElementById('optionAArrayhid').value=vuedata.optionAArray.join('`');
document.getElementById('optionBArrayhid').value=vuedata.optionBArray.join('`');
document.getElementById('optionCArrayhid').value=vuedata.optionCArray.join('`');
document.getElementById('optionDArrayhid').value=vuedata.optionDArray.join('`');
document.getElementById('answersChosenhid').value=vuedata.answersChosen;
document.getElementById('correctAnshid').value=vuedata.correctAns;
document.forms["test-taken"].submit();

} else {
seconds--;
}
}
var countdownTimer = setInterval('secondPassed()', 1000);
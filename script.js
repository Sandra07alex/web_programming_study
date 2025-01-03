const quizdata=[
{
	question :"which type of language is javascript",
	options :["onject-oriented","object-based","assembly language","high-level"],	
	answer:"objected-based"
},
{
	question : "What is the main use of JavaScript?",
	options :["To create databases", "To structure HTML documents", "To add interactivity to web pages", "To manage server-side requests"],	
	answer:"To add interactivity to web pages"
},
{
	question :"Which of the following is not a JavaScript data type?",
	options :["String", "Boolean", "Number", "Float"],	
	answer:"Float"

},
{
	question :Which function is used to parse a string to an integer in JavaScript?",
	options :["parseInt()", "parseFloat()", "toString()", "Number()"],	
	answer:"parseInt()"
}];
const quizContainer=document.getElementById('quiz');
const resultContainer=document.getElementById('result');
const submitButton=document.getElementById('submit');
const retryButton=document.getElementById('retry');
const showAnswerButton=document.getElementById('ShowAnswer');


let currentQuestion=0;
let score=0;
let incorrectAnswer=[];
displayQuestion();













function displayQuestion(){
const questionData=quizdata[currentQuestion];

const questionElement=document.createElement('div');
questionElement.className="question";
questionElement.innerHTML=questionData.question;

const optionElement=document.createElement('div');
optionElement.className="option";
const shuffledOption=questionData.option;

for(let i=0;i<shuffledOption.length;i++){
const option=document.createElement('div');
option.ClassName='option';



const radio=document.createElement("input");
radio.type='radio';
radio.name-'quiz';
radio.value= shuffleoption[i];

const optionText=document.createTextNode(shuffleoption[i]);

option.appendChild(radio);
option.appendChild(OptionText);
optionElement.appendChild(Option);

}
quizContainer.innerHTML='';
quizContainer.appendChild(questionElement);
quizContainer.appendChild(optionsElement);
}
function checkAnswer(){
const selectedOption =document.querySelector("input[name="quiz"]:checked);

if(selectedOption)
{
	const answer==selectedoption.value;
	if(answer===quizData[currentQuestion].answer)
	{
	score++;
	}
	else
	{
	incorrectedAnswer.push({
question:quizData[currentQuestion].question ,
incorrectanswer: answer,
correctAnswer:quizData[currentQuestion].answer,});
	
	}
	currentQuestion++;
selecedOption.checked=false;
if(currentQuestion<quizData.length){
displayQuestion();
}else{
displayResult();


}

}

}
function displayResult(){
quizcontaioner.style.display="none";
submitbutton.style.display="none";


}
























}
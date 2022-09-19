@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{auth()->user()->name}} , {{ __('Dashboard') }} <span style="float:right" class="showTimer"></span><input type='hidden' id='submition_time' ><input type='hidden' id='total_questions' ></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" id="show_message" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    @if($quiz_test_by_examinee)
                        <div id="test_result_show">
                            <h2 style="text-align: center;">Result:</h2>
                            <h5  style="text-align: center;">You've performed total <span id="performed_quiz">{{$quiz_test_by_examinee->quiz_perform_qty}}</span> Out of <span id="total_quiz">{{$quiz_test_by_examinee->total_questions}}</span></h5>
                            @php($percentage_of_mark = (($quiz_test_by_examinee->quiz_pass_qty/$quiz_test_by_examinee->total_questions)*100))
                            <h5  style="text-align: center;"> Pass Quantity: <span id="pass_quantity">{{$quiz_test_by_examinee->quiz_pass_qty}}</span></h5>
                            <h5  style="text-align: center;"> Mark of Percentage: <span id="percentage_of_marks">{{number_format($percentage_of_mark)}}%</span></h5>
                            <h5  style="text-align: center;"> Time Spent: <span id="time_spent">{{$quiz_test_by_examinee->time_consumed}}</span></h5>
                            <h3 style="text-align: center;">Thank You For Attending The Quiz Test!!</h3>
                        </div>
                    @else
                        <div id="intialInfo">
                            @if(auth()->user()->role_as == 1)
                                <!-- @foreach(json_decode($quizzes) as $quiz)
                                    Welcome {{auth()->user()->name}} {{ __(', You are and logged in!') }}<br>
                                    Name: {{$user->name}}<br>
                                    Phone: {{$user->phone}}<br>
                                    CV: <a  href="{{ url('/show-cv-link',$user->cv_link) }}">Download PDF</a><br>
                                @endforeach -->
                            @else 
                                @if(auth()->user()->status == 'pending')
                                    Welcome {{auth()->user()->name}} {{ __(', You are Registered and logged in Successfully. Your CV will be Reviewed by our Team. After that  you will get confirmation for the test. Thank you.') }}<br>
                                @elseif(auth()->user()->status == 'approved')
                                    Welcome {{auth()->user()->name}} {{ __(', Now you are eligible for the quiz test. You will get 2 minutes for 10 quizzes.If you are ready, please, get start by clicking the "Start Quiz" button.') }}<br>
                                    <button type="button" id="countDownTimer" class="btn btn-primary">Start Quiz</button><br>
                                
                                @endif
                                
                                Name: {{auth()->user()->name}}<br>
                                Phone: {{auth()->user()->phone}}<br>
                                CV: <a  href="{{ url('/show-cv-link',auth()->user()->cv_link) }}">Download PDF</a><br>
                            @endif
                        </div>
                        <div id="quizDetails">
                            <div id="showRemaining" style="float:right">

                            </div>
                            <div id="question">

                            </div>
                            <div id="question_options">

                            </div>                        
                            
                        <div id="next_button">
                                <!-- <button style="float:left" class="btn btn-default" id="decrease"><< Previous</button> -->
                                <button style="float:right" class="btn btn-warning" id="increase">Next >></button>
                        </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#quizDetails').hide();
        // $('#test_result_show').hide();
    });
    var ob_arry = [];
    var data_arry = [];
    $('#countDownTimer').click(function(){
        $('#intialInfo').remove();
        $('#quizDetails').show();
        $('#show_message').hide();
        // Quiz div function
        
        var countDownDate = new Date(new Date().getTime() + 02*60000);// Exam for 2 minutes
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();                
            // Find the distance between now and the count down date
            var distance = countDownDate - now;                
            // Time calculations for days, hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);           
            $('.showTimer').html(hours + "H " + minutes + "m " + seconds + "s ");
            // Consumed Time
            if(hours < 0 && minutes < 0 && seconds < 0){
                $('#submition_time').val("00:00:00");
            }else{
                $('#submition_time').val(hours+":"+minutes+":"+seconds);
            }
            // If the count down is over
            if (distance <= 0) {
                clearInterval(x);
                
                $('#quizDetails').html("<button type='submit'  onclick='saveData()' class='btn btn-success'>Submit</button>");
                $('.showTimer').html("TIME OUT");
            }
        }, 1000);
        showQuiz(x)
    });
    
    function showQuiz(x){
        let questions = JSON.stringify(<?php echo $quizzes?>);
        let showQuestions = JSON.parse(questions);
        quizDetails(0);// First Quiz
        var t = 1;
        $('#increase').on('click', function() {
            ob_arry = [];
            quizDetails(t);// Quiz increament
            t++;
        });

        function quizDetails(n){// Quiz Show function
            if(showQuestions.length > 0){
                if(n < showQuestions.length){ 
                    // showRemaining
                    $('#showRemaining').html('<strong>'+(n+1)+' Out of '+ showQuestions.length+'</strong>');
                    $('#total_questions').val(showQuestions.length);
                    let q_option = JSON.parse(showQuestions[n].options);
                    if(showQuestions[n].options_type == "checkbox"){
                        var opt_type ="(Check can be more then one)";
                    }else{
                        var opt_type ="";
                    }
                    $('#question').html("<strong> Q - "+(n+1)+': ' +showQuestions[n].question+'<br>'+opt_type+'</strong><br><br>');
                    var html_data = "";
                    $.each(q_option,function(key,value){
                        html_data += '<input type="'+showQuestions[n].options_type+'" name="quiz" id="'+key+'" value="'+key+'" onchange="storeData(\''+showQuestions[n].options_type+'\',\''+showQuestions[n].id+'\',\''+key+'\')" > '+value+'<br>';
                    });                    
                    $('#question_options').html(html_data);
                }else if(n > showQuestions.length){
                    clearInterval(x);
                    alert('You have completed the Test.Please Submit The Test.');
                    $('#quizDetails').html("<button type='submit' onclick='saveData()' class='btn btn-success'>Submit</button>");
                }
            }else{
                $('#quizDetails').html("No Question yet found.");
                $('#next_button').hide();
            }
        }            
            
    }
    
        
    function storeData(type,op_no,op_val){ // store data into local storage
        
        var chekb = document.getElementById(op_val);
        var objct = [];
        
        if(type == "checkbox"){// If quiz with checkbox
            data_arry = [];
            if(chekb.checked == true){ // if checked value push into array               
                ob_arry.push(op_val);
                data_arry.push(ob_arry.join(','));
                localStorage.setItem(op_no, data_arry);
                
            }else{ //if unchecked value remove from array
                if ((index = ob_arry.indexOf(op_val)) !== - 1) {
                    ob_arry.splice(index, 1);                    
                }
                data_arry.push(ob_arry.join(','));
                localStorage.setItem(op_no, data_arry);
                // ob_arry = [];
                 
            }
           
        }else{// If quiz with radio
            var data_arry = [];
            if(chekb.checked == true){ 
                objct[op_no] = op_val;
                data_arry.push(objct[op_no]);
            }
            localStorage.setItem(op_no, data_arry);
        }
       
        // localStorage.setItem(op_no, data_arry);
    }
    function saveData(){// Final submition for store data into database from localstorage
        var localData = [];
        for (let [key, value] of Object.entries(localStorage)) {
        // console.log(`${key}: ${value}`);
            localData.push(`${key}: ${value}`)
        }
        var submition_time = $("#submition_time").val();
        var total_questions = $("#total_questions").val();
        $.ajax({
            url: "{{ url('/store-quiz-test-data') }}",
            type: 'POST',
            datatype: 'xml, json, script, html',
            cache: 'false',
            data: {
                quizData: localData,
                submition_time:submition_time,
                total_questions:total_questions,
                _method: 'POST',                      
                _token:  '{{ csrf_token() }}'
            },
            success: function(result){
                $('#quizDetails').hide();
                $('#test_result_show').show();
                try {  // check for returning json data
                    const jsondta = JSON.parse(result);
                    $('#performed_quiz').html(jsondta.quiz_perform_qty);
                    $('#pass_quantity').html(jsondta.quiz_pass_qty);
                    $('#percentage_of_marks').html(((jsondta.quiz_pass_qty/jsondta.total_questions) *100 ).toFixed(2) +'%');
                    $('#total_quiz').html(jsondta.total_questions);
                    $('#time_spent').html(jsondta.time_consumed);
                } catch (e) {  
                    console.log('invalid json');  
                }
                
                localStorage.clear();
                location.reload();
            },
            error: function (data) {
                console.log(data);
            }
        });
       
    }

</script>
@endsection

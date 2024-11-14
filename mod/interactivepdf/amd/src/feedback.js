define(['jquery','core/notification','core/ajax'], function($,notification,ajax) {
    function submit_feedback(userid, interactivepdfid, attemptid, subquestionid, feedback, feedbackcomment, formId){
        let wsfunction = 'save_feedback';
        let params = {
            'interactivepdfid': interactivepdfid,
            'userid': userid,
            'attemptid': attemptid,
            'subquestionid': subquestionid,
            'feedback': feedback,
            'feedbackcomment': feedbackcomment,
        };
        let request = {
            methodname: wsfunction,
            args: params
        };

        try {
            ajax.call([request])[0].done(function(data) {
                if (data.success == 1) {
                    $('#'+formId).addClass('d-none');
                    notification.addNotification({
                        message: 'Feedback saved',
                        type: 'success'
                    });

                } else {

                }
            });
        } catch (e) {
        }
    }


    return {
        init: function(userid, interactivepdfid, attemptid) {
            $(document).ready(function() {
                $('.redio-btn').on('change', function() {
                    if ($(this).is(':checked')) {
                        event.preventDefault();
                        var quizid = $(this).data('id');
                        var value = $(this).val();
                        var quiztype = $(this).data('quiztype');
                        submit_feedback(userid,interactivepdfid,attemptid,quizid,quiztype,value);
                    }
                });

                $(".feedback-submit-btn").on("click", function(event) {
                    event.preventDefault();
                    var formId = $(this).closest('form').attr('id'); // Retrieve the dynamic form ID
                    const form = event.target.closest('#'+formId);
                    const formData = new FormData(form);
                    var feedback = 0;
                    for (const entry of formData) {
                       if(entry[0] == 'subquestionid') {
                        var subquestionid =  entry[1];
                       }
                        if(entry[0] == 'subquestion-feedback') {
                            var feedback =  entry[1];
                        }
                        if(entry[0] == 'feedbackcomment') {
                            var feedbackcomment =  entry[1];
                        }
                    }
                    submit_feedback(userid, interactivepdfid, attemptid, subquestionid, feedback, feedbackcomment, formId);
                });
            });
        }

    };
});

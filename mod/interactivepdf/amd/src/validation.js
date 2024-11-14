define(['jquery','core/notification','core/ajax'], function($,notification,ajax) {
    /**
     *
     * @param userid
     * @param quiz_id
     * @param interactivepdfid
     * @param attemptid
     * @param answer
     * @param quiz_type
     */
    function submit_form(userid,quiz_id,interactivepdfid,attemptid,answer,quiz_type,quiz_3nid = null,ansid=null){

        if (quiz_type == 'shortques') {
            let wsfunction = 'save_question_answer';
            let params = {
                'user_id': userid,
                'quiz_id': quiz_id,
                'interactivepdfid': interactivepdfid,
                'attemptid': attemptid,
                'answer': answer,
                'quiz_type': quiz_type,
            };
            let request = {
                methodname: wsfunction,
                args: params
            };

            try {
                ajax.call([request])[0].done(function(data) {
                    if (data.success == 1) {

                    } else {

                    }
                });
            } catch (e) {
            }
        }
        else if(quiz_type == '3nques'){
            let wsfunction = 'save_3n_question_answer';
            let params = {
                'user_id': userid,
                'quiz_id': quiz_id,
                'interactivepdfid': interactivepdfid,
                'attemptid': attemptid,
                'answer': answer,
                'quiz_type': quiz_type,
                'ansid': ansid,
                'quiz_3nid': quiz_3nid,
            };
            let request = {
                methodname: wsfunction,
                args: params
            };

            try {
                ajax.call([request])[0].done(function(data) {
                    if (data.success == 1) {

                    } else {

                    }
                });
            } catch (e) {
            }
        }
        else if(quiz_type == '2nm'){
            let wsfunction = 'save_2nm_question_answer';
            let params = {
                'user_id': userid,
                'quiz_id': quiz_id,
                'interactivepdfid': interactivepdfid,
                'attemptid': attemptid,
                'answer': answer,
                'quiz_type': quiz_type,
                'ansid': ansid,
                'quiz_3nid': quiz_3nid,
            };
            let request = {
                methodname: wsfunction,
                args: params
            };

            try {
                ajax.call([request])[0].done(function(data) {
                    if (data.success == 1) {

                    } else {

                    }
                });
            } catch (e) {
            }
        }
        else if(quiz_type == '2ns'){
            let wsfunction = 'save_2ns_question_answer';
            let params = {
                'user_id': userid,
                'quiz_id': quiz_id,
                'interactivepdfid': interactivepdfid,
                'attemptid': attemptid,
                'answer': answer,
                'quiz_type': quiz_type,
                'ansid': ansid,
                'quiz_3nid': quiz_3nid,
            };
            let request = {
                methodname: wsfunction,
                args: params
            };

            try {
                ajax.call([request])[0].done(function(data) {
                    if (data.success == 1) {

                    } else {

                    }
                });
            } catch (e) {
            }
        }

    }
    function finish_attempt(userid,interactivepdfid,attemptid){

        let wsfunction = 'finish_attempt';
        let params = {
            'user_id': userid,
            'interactivepdfid': interactivepdfid,
            'attemptid': attemptid,
        };
        let request = {
            methodname: wsfunction,
            args: params
        };

        try {
            ajax.call([request])[0].done(function(data) {
                if (data.success == 1) {
                    //
                    // // Add the message to the notification system
                    send_notification(userid,interactivepdfid,attemptid);
                    location.reload();
                } else {

                }
            });
        } catch (e) {
        }
    }

    function send_notification(userid,interactivepdfid,attemptid){

        let wsfunction = 'send_notification';
        let params = {
            'user_id': userid,
            'interactivepdfid': interactivepdfid,
            'attemptid': attemptid,
        };
        let request = {
            methodname: wsfunction,
            args: params
        };

        try {
            ajax.call([request])[0].done(function(data) {
                if (data.success == 1) {

                } else {

                }
            });
        } catch (e) {
        }
    }

    return {
        init: function(userid, interactivepdfid,attemptid) {
            attemptid = parseInt(attemptid);
            $(document).ready(function() {

                $("#attempt-submit-btn").on("click", function(event) {
                    event.preventDefault();
                    var formId = $(this).closest('form').attr('id'); // Retrieve the dynamic form ID

                    const form = event.target.closest('#'+formId);
                    const formData = new FormData(form);

                    // Loop through form data
                    for (const entry of formData) {
                        var quiz_id = $(('#'+entry[0])).attr("data-id");
                        var quiz_type = $(('#'+entry[0])).attr("data-type");
                        var quiz_3nid = null;
                        var ansid = null;
                        if (quiz_type == '3nques' || quiz_type == '2nm' || quiz_type == '2ns'){
                            quiz_3nid = $(('#'+entry[0])).attr("data-qid");
                            ansid = $(('#'+entry[0])).attr("data-ansid");
                        }
                        var answer= '';
                        answer = entry[1];
                        submit_form(userid,quiz_id,interactivepdfid,attemptid,answer,quiz_type,quiz_3nid,ansid);
                    }

                    finish_attempt(userid,interactivepdfid,attemptid);
                    return false;
                });

                $(".question-submit-btn").on("click", function(event) {
                    event.preventDefault();
                    var formId = $(this).closest('div').attr('id'); // Retrieve the dynamic form ID
                    var quiz_id = $(('#'+formId)).attr("data-id");
                    var quiz_type = $(('#'+formId)).attr("data-type");
                    var answer = $('textarea[name="'+quiz_type+'-'+quiz_id+'"]').val();

                    submit_form(userid,quiz_id,interactivepdfid,attemptid,answer,quiz_type);

                    return false;
                });
            });
        }

    };
});

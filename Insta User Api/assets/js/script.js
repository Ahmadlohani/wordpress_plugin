jQuery(function($){

    // Function to be called on changing Instagram Username

    $("#billing_insta_user").on("change", function() {
        $("#place_order").attr("disabled", true);
        $('#insta_posts').empty();
        $('#loading_posts').empty();
        $value = $(this).val();
        // Ajax request to initiate ajax for insta posts

        $.ajax({
            type: "post",
            datatype: "json",
            url: my_ajax_object.ajax_url,
            data: {action: "my_ajax_action", user_name: $value},
            beforeSend: function() {
                
                $('#loading_posts').append(
                '<img style="display: block;width: 60px;height: 60px;margin: 0 auto;" src="/api_images/load.gif"/>'
                );
            },
            complete: function(){
                $('#loading_posts').empty();
            },
            success: function(result){
                $response = JSON.parse(result);
                if ($response.success == "yes") {
                    $('#loading_posts').empty();
                    $("#insta_posts").append($response.profile);
                    $userProfile = $response.data;
                    $username = $userProfile.full_name;
                    $profile_id = $userProfile.user_id;
                    $profile_image = $(".profile_image").val();
                    $data = [];
                    $cat_name = [];
                    $cat_name[0] = $response.instaData[0];
                    $service_id = $response.instaData[1];
                    $quantity = $response.instaData[2];
                    $data.push({
                        "insta_username" : $username, 
                        "user_profile_id" : $profile_id,
                        "profile_image" : $profile_image,
                        "service_id" : $service_id,
                        "cat_name" : $cat_name,
                        "quantity" : $quantity
                    });
                    
                    $.ajax({
                        type: "post",
                        datatype: "json",
                        url: my_ajax_object.ajax_url,
                        data: {action: "item_meta_action", userdata: $data},
                        success: function(res){
                            console.log(res);
                        },
                        error: function () {
                            alert("Failed to add user profile meta");
                        }
                    }); 
                } else{  

                    $('#loading_posts').empty();
                    $('#loading_posts').html("<p>User posts could not be found</p>").css({
                        "color": "red",
                        "text-align": "center"
                    });
                }
            },
            error: function() {
                alert("Failed to fetch Insta posts");
            },
        });
    })
    var $ = jQuery;

    $(document).on("click", "#loadmorebtn", function () {
        var user_id = $(this).attr('data-userId');
        var token = $(this).attr('data-userToken');
        var postCount = $('.posts-image').length;
        var data = {
            action: "get_more_posts",
            user_id: user_id,
            token: token,
            count: postCount
        };
        sendAjaxReq(data);
        event.preventDefault();
        return false;
    });

    function sendAjaxReq(data) {
        $.ajax({
            type: "post",
            dataType: "json",
            url: my_ajax_object.ajax_url,
            data: data,
            success: function (response) {
                if (response.success == "yes") {
                    $('.lmorefl').remove();
                    $('.insta_posts').append(response.load_more);                
                }
            },
            error: function () {
                alert("Failed loading more posts");
            }
        });
    }
    
    // Function triggered on clicking images
    $(document).on ('click',".posts-image",function() {
        $(this).toggleClass("selected");
        $len = "";
        $len = $(".selected").length;
        if ($len > 2) {
            alert("You can choose only limited pictures");
            $(this).removeClass("selected");
            return false;
        }
        $imgmeta  = [];
        // Getting source of Selected images
        $(".selected").each(function () {
            $post_id = [];
            $quantity = [];
            $thumbnail = [];
            $post_id.push ($(this).attr("data-id"));
            $quantity.push ($(this).attr("qtty") / $len);
            $thumbnail.push ("");
            $imgmeta.push({               
                "post_id" : $post_id,
                "quantity" : $quantity,
                "thumbnail" : $thumbnail
            });
        });

        // Ajax call to send selected images to item meta
        
        $.ajax({
            type: "post",
            datatype: "json",
            url: my_ajax_object.ajax_url,
            data: {action: "image_item_meta_action", imgmeta: $imgmeta},
            success: function(data){
                $("#place_order").attr("disabled", false);
                console.log(data);
            },
            error: function () {
                alert("Failed to add image meta");
            }
        })
    });
}) 
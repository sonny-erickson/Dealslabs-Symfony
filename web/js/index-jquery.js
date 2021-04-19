$(function (){

    $(".disabledEl").addClass("disabledButton");
    $(".disabledEl button").addClass("d-none");

    // popover informations user
    $('[data-toggle="popover"]').popover({ trigger: "hover" });

    handleVote();
    onShowModalInformation();
    onScrollWindow();
});
//When scroll bottom
function onScrollWindow(){
    $(window).on("scroll", function() {
        var lastDeal = $('.deal:last-child');
        var positionLastDeal = lastDeal.data('position');
        var typeSearch = $('.dealsContainer').data('type_search');
        var nbDeal = 5;
        if($(window).scrollTop() + $(window).height() >= $(document).height())
        {
            $.ajax({
                method: "POST",
                url: "/ajax/paginate/deals",
                data: {position: positionLastDeal, nbDeal: nbDeal, typeSearch: typeSearch},
                dataType: "json",
                beforeSend: function () {
                    $('#loader').removeClass('d-none')
                },
                error: function (){
                    $('#loader').remove();
                    $(document).scrollTop(0);
                    $('#error').addClass("alert alert-danger text-center my-3")
                        .text("Impossible de scroll pour le moment")
                }
            })
                .done(function (data){
                    if(data.nbDealsReturned === 0){
                        $("#stopScrollNbDeals").removeClass("d-none");
                        $(window).off("scroll");
                        $('#loader').remove();
                    }else{
                        $(".dealsContainer").append(data.html);
                        onShowModalInformation();
                        handleVote();
                        $('#loader').addClass('d-none');
                    }
                });
        }
    });
}
//Incremente Ajax
function handleVote(){
    $(".increment").off("click").on("click", function() {
        var that = $(this);
        var $parentCounters = that.parents(".deal"),
            idDeal = $parentCounters.data("id_deal"),
            upDown = "";
        var $myCounter = $parentCounters.find(".count");
        var $counter = that.parents(".counter");

        if (that.hasClass("up")) {
            upDown = "up";
        } else if (that.hasClass("down")) {
            upDown = "down";
        }
        if(upDown){
            $.ajax({
                method: "POST",
                url: "/ajax/deal/updateCounter",
                data: {idDeal: idDeal, upDown: upDown},
                dataType: "json",
                error: function (){
                    $(document).scrollTop(0);
                    $('#error').addClass("alert alert-danger text-center my-3").text('Système comptage de point indisponble pour le moment')
                }
            })
                .done(function (data){
                    console.log(data)
                    $myCounter.html(data);
                    $($counter).addClass("disabledButton");
                });
        }
    })
}
// Modal boot
function onShowModalInformation() {
    var modalBody = $('.modal-body');
    var modalBodyLoading = modalBody.find("#Loading");
    var modalBodyContent = modalBody.find("#Content");
    //Plus infos grâce modal
    $(".modalCall").off("click").on("click", function() {
        var that = $(this);
        var idDeal = that.data('id');
        $.ajax({
            method: "POST",
            url: "/deal/"+idDeal,
            data: {idDeal: idDeal},
            dataType: "json",
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('.modal-body').find("#Loading").removeClass('d-none')
            },
        })
            .done(function (data){
                modalBodyLoading.addClass("d-none");
                modalBodyContent.removeClass("d-none");
                modalBodyContent.html(data.html);
            })
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        modalBodyLoading.removeClass("d-none");
        modalBodyContent.addClass("d-none");
        modalBodyContent.find("#Content").html("");
    })
}
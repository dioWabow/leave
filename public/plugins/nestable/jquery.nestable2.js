/*jslint browser: true, devel: true, white: true, eqeq: true, plusplus: true, sloppy: true, vars: true*/
/*global $ */

/*************** General ***************/

var nestableList = $("#nestable > .dd-list");

/***************************************/


/*************** Delete ***************/

var deleteFromMenuHelper = function(target) {
    if (target.data('new') == 1) {
        // if it's not yet saved in the database, just remove it from DOM
        target.fadeOut(function() {
            target.remove();
        });
    } else {
        // otherwise hide and mark it for deletion
        target.appendTo(nestableList); // if children, move to the top level
        target.data('deleted', '1');
        target.fadeOut();
    }
};

var deleteFromMenu = function() {
    var targetId = $(this).data('owner-id');
    var target = $('[data-id="' + targetId + '"]');

    var result = confirm("Delete " + target.data('name') + " and all its subitems ?");
    if (!result) {
        return;
    }

    // Remove children (if any)
    target.find("li").each(function() {
        deleteFromMenuHelper($(this));
    });

    // Remove parent
    deleteFromMenuHelper(target);
};

/***************************************/


/*************** Edit ***************/

var menuEditor = $("#menu-editor");
var editButton = $("#editButton");
var editInputName = $("#editInputName");
var currentEditName = $("#currentEditName");

// Prepares and shows the Edit Form
var prepareEdit = function() {
    var targetId = $(this).data('owner-id');
    var target = $('[data-id="' + targetId + '"]');

    $("#editInputName").val(target.data("name"));
    $("#currentEditName").html(target.data("name"));
    $("#editButton").data("owner-id", target.data("id"));

    //console.log("[INFO] Editing Menu Item " + editButton.data("owner-id"));

    $("#menu-editor").fadeIn();
};

// Edits the Menu item and hides the Edit Form
var editMenuItem = function() {
    var targetId = $(this).data('owner-id');
    var target = $('[data-id="' + targetId + '"]');

    var newName = $("#editInputName").val();

    target.data("name", newName);
    target.find("> .dd-handle").html(newName);

    $("#menu-editor").fadeOut();
};

/***************************************/


/*************** Add ***************/

var newIdCount = 1;

var addToMenu = function() {
    var newName = $("#addInputName").val();
    var newId = 'new-' + newIdCount;

    $("#nestable > .dd-list").append(
        '<li class="dd-item" ' +
        'data-id="' + newId + '" ' +
        'data-name="' + newName + '" ' +
        'data-new="1" ' +
        'data-deleted="0">' +
        '<div class="dd-handle">' + newName + '</div> ' +
        '<span class="button-delete btn btn-default btn-xs pull-right" ' +
        'data-owner-id="' + newId + '"> ' +
        '<i class="fa fa-times-circle-o" aria-hidden="true"></i> ' +
        '</span>' +
        '<span class="button-edit btn btn-default btn-xs pull-right" ' +
        'data-owner-id="' + newId + '">' +
        '<i class="fa fa-pencil" aria-hidden="true"></i>' +
        '</span>' +
        '</li>'
    );

    newIdCount++;

    // set events
    $("#nestable .button-delete").on("click", deleteFromMenu);
    $("#nestable .button-edit").on("click", prepareEdit);
};



/***************************************/



$(function() {

    // set onclick events
    $("#editButton").on("click", editMenuItem);

    $("#nestable .button-delete").on("click", deleteFromMenu);

    $("#nestable .button-edit").on("click", prepareEdit);

    $("#menu-editor").submit(function(e) {
        e.preventDefault();
    });

    $("#menu-add").submit(function(e) {
        e.preventDefault();
        addToMenu();
    });

});
function deleteSqueak(squeakId) {
  $.ajax({
    type: "POST",
    url: `${url}/deleteSqueak.php`,
    data: `id=${squeakId}`
  }).then(({ data }) => {
    if (data.id) {
      $(`#${data.id}`).remove();
    }
  }).catch(error => {
    console.log("ERROR", error);
    alert(error.responseText);
  });
}

function likeSqueak(squeakId) {
  $.ajax({
    type: "POST",
    url: `${url}/likeSqueak.php`,
    data: `id=${squeakId}&value=1`
  }).then(({ data }) => {
    if (data) {
      const squeakLikeElement = $(`#${data.id}`).find('.squeak_like-count');
      squeakLikeElement.text(Number(squeakLikeElement.text())+1);
    }
  }).catch(error => {
    console.log("ERROR", error);
    alert(error.responseText);
  });
}

function unLikeSqueak(squeakId) {
  $.ajax({
    type: "POST",
    url: `${url}/likeSqueak.php`,
    data: `id=${squeakId}&value=-1`
  }).then(({ data }) => {
    if (data) {
      const squeakLikeElement = $(`#${data.id}`).find('.squeak_like-count');
      squeakLikeElement.text(Number(squeakLikeElement.text())-1);
    }
  }).catch(error => {
    console.log("ERROR", error);
    alert(error.responseText);
  });
}

const createSqueak = squeak => $(`
<div id="${squeak.id}" class="squeak card">
  <h3>${squeak.username}</h3>
  <p>${squeak.message}</p>
  <p class="squeak_likes">Likes: <span class="squeak_like-count">${squeak.likeCount}<span></p>
  <a onclick="deleteSqueak('${squeak.id}')" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">delete</i></a>
  <a onclick="likeSqueak('${squeak.id}')" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">thumb_up</i></a>
  <a onclick="unLikeSqueak('${squeak.id}')" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">thumb_down</i></a>
</div>
`);

function getAllSqueaks(data) {
  $.ajax({
    type: "GET",
    url: `${url}/squeaks.php`,
    data: data
  }).then(({data}) => {
    $('.all-squeaks').empty();
    for(const id in data) {
      const squeak = data[id];
      createSqueak(squeak).appendTo('.all-squeaks');
    }

  }).catch(error => {
    console.log("ERROR", error);
    alert(error.responseText);
  });
}

getAllSqueaks();

function postSqueak(data) {
  $.ajax({
    type: "POST",
    url: `${url}/squeaks.php`,
    data: data
  }).then(({data}) => {
    // createSqueak(squeak).prependTo('.all-squeaks');
    getAllSqueaks();
  }).catch(error => {
    console.log("ERROR", error);
    alert(error.responseText);
  });
}


$("#new-squeak-form").on("submit", function(event) {
  event.preventDefault();
  const data = $(this).serialize();
  postSqueak(data);
});


$("#filter-squeaks-form").on("submit", function(event){
  event.preventDefault();
  const data = $(this).serialize();
  getAllSqueaks(data);
});


$(document).ready(function(){
  $('select').formSelect();
});
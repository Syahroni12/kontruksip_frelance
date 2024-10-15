const chatItems = document.querySelectorAll('.wrapper');
const chatDetail = document.querySelector('.wrapper-right');
const chatList = document.querySelector('.wrapper-left');
const btnBack = document.querySelector('.btn-back');

chatItems.forEach(item => {
    item.addEventListener('click', function() {
        if (window.innerWidth <= 450 || window.innerWidth <= 768) {
            chatList.style.display = 'none';
            chatDetail.style.display = 'block';
            btnBack.classList.remove('d-none');
            chatDetail.style.height = '490px'
        }
        else {
            btnBack.classList.add('d-none');
        }
    });
});

function goBack() {
const chatDetail = document.querySelector('.wrapper-right');
const chatList = document.querySelector('.wrapper-left');

chatDetail.style.display = 'none';
chatList.style.display = 'block';
}

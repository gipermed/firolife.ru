export const isFavorite = offers => new Promise((resolve, reject) => {
    axios.get('/ajax/', {
        params: {
            ID: offers,
            action: 'is-favorite',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        let favInfo = response.data.result['favorite'];
        // if(favInfo)
        //     $(".add-to-favorites-btn").addClass("active")
        resolve(favInfo);
    }).catch(response => reject(response));
});
export const isFavoriteShow = (offers,obj) => new Promise((resolve, reject) => {
    isFavorite(offers).then(response => {
        if (response) {
            toggleClassFav(obj,true)
            resolve(response);
        }
    }).catch(response => reject(response));
});

function toggleClassFav(obj,add) {
    if(add)
    {
        $(obj).addClass("active").find('span').text("Удалить из избранного")
    }
    else
    {
        $(obj).removeClass("active").find('span').text("В избранное")
    }
}

export const clickFavorite = (offers,obj) => new Promise((resolve, reject) => {
    isFavorite(offers).then(response => {

        if (response) {
            removeFromFavorite(offers,obj).then(response => {
                resolve(response);
            }).catch(response => reject(response))
        } else {

            addToFavorite(offers,obj).then(response => {
                resolve(response);
            }).catch(response => reject(response))
        }
    }).catch(response => reject(response));
});

export const addToFavorite = (offers,obj) => new Promise((resolve, reject) => {
    axios.get('/ajax/', {
        params: {
            ID: offers,
            action: 'add-to-favorites',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        if (response.data.success) {
            toggleClassFav(obj,true);
            resolve(response);
        }
    }).catch(response => reject(response))
})

export const removeFromFavorite = (offers,obj) => new Promise((resolve, reject) => {
    axios.get('/ajax/', {
        params: {
            ID: offers,
            action: 'remove-from-favorites',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        if (response.data.success) {
            toggleClassFav(obj,false);
            resolve(response);
        }
    }).catch(response => reject(response))
})
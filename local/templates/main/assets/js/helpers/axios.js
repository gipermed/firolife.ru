function ajaxResponseCallback(response, resolve, reject) {
    if (response.data.success) {
        resolve(response);
    } else {
        let error = response.data.errors[0] ? response.data.errors[0].message : '';

        error && console.error(error);

        reject(response);
    }
}

export const makeFormData = (action, data = {}) => {
    let formData = new FormData(),
        params = {
            sessid: BX.bitrix_sessid(),
            action: action,
            ...data
        };

    for (let key in params) {
        if (params.hasOwnProperty(key)) {
            formData.append(key, params[key]);
        }
    }

    return formData;
}

export const postRequest = formData => {
    return new Promise((resolve, reject) => {
        window.axios.post('/ajax/', formData).then(response => ajaxResponseCallback(response, resolve, reject));
    })
}

export const getRequest = (action, data = {}) => {
    let params = {
        sessid: BX.bitrix_sessid(),
        action: action,
        ...data
    };

    return new Promise((resolve, reject) => {
        window.axios.get('/ajax/', {params}).then(response => ajaxResponseCallback(response, resolve, reject));
    })
}

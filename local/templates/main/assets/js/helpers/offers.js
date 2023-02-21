export const extractIdentifiersFromProducts = products => products
    .map(product => product['OFFERS'])
    .map(offers => offers.map(offer => offer['ID']))
    .reduce((accumulator, current) => accumulator.concat(current), []);

export const availableQuantities = offers => new Promise((resolve, reject) => {
    axios.get('/ajax/', {
        params: {
            ID: offers,
            action: 'product-info',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        let offersInfo = response.data.result['INFO'];

        resolve(offersInfo);
    }).catch(response => reject(response));
});

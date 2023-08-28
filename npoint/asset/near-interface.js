import { THIRTY_TGAS } from "./near-wallet";
import { connect, keyStores, utils } from "near-api-js";

export class NSub {
  constructor({ contractId, walletToUse }) {
    this.contractId = contractId;
    this.wallet = walletToUse;
  }

  /**
   * 
   * @param {float} price price in float  
   * @param {string} receiver receiver NEAR wallet 
   * @param {string} callbackurl call back Url 
   * @returns 
   */
  async pay(price, receiver, callbackurl = "") {
    let yNear = utils.format.parseNearAmount(price);

    return await this.wallet.callMethod({
      contractId: this.contractId,
      method: 'pay',
      args: { price: yNear, receiver: receiver },
      gas: THIRTY_TGAS,
      deposit: yNear,
      callbackUrl: callbackurl
    });

  }

  /**
   * 
   * @param {float} price price in float  
   * @param {string} receiver receiver NEAR wallet 
   * @param {string} callbackurl call back Url 
   * @returns 
   */
  async donate(price, receiver, callbackurl = "") {
    let yNear = utils.format.parseNearAmount(price);

    return await this.wallet.callMethod({
      contractId: this.contractId,
      method: 'pay',
      args: { price: yNear, receiver: receiver },
      gas: THIRTY_TGAS,
      deposit: yNear,
      callbackUrl: callbackurl
    });
  }

  //get tx result 
  async getTxResult(txhash) {
    let rs = await this.wallet.getTransactionResult(txhash);
    console.log("txhashresult", rs);
  }

  //check if account exist

  async getAccountBalance(walletId) {
    let nearconnection = await connect({ ...this.wallet.walletSelector.options.network, keyStore: new keyStores.BrowserLocalStorageKeyStore() });
    let account = await nearconnection.account(walletId);
    try {
      let accountBalance = await account.getAccountBalance();
      return accountBalance;
    } catch (error) {
      console.log("Error: " + error.message);
      return false;
    }
  }
}
const envpath = '/home/cuong/projects/npoint/nodejs-scripts/.env';
require("dotenv").config({path:envpath});
const { utils } = require("near-api-js");
const nearAPI = require("near-api-js");
const { connect, keyStores, KeyPair } = nearAPI;

const CREATOR_WALLET_ADDR = process.env.CREATOR_WALLET_ADDR;
const PRIVATE_KEY = process.env.PRIVATE_KEY;
const myKeyStore = new keyStores.InMemoryKeyStore();

const connectionConfig = {
  networkId: "testnet",
  keyStore: myKeyStore, // first create a key store 
  nodeUrl: "https://rpc.testnet.near.org",
  walletUrl: "https://wallet.testnet.near.org",
  helperUrl: "https://helper.testnet.near.org",
  explorerUrl: "https://explorer.testnet.near.org",
};

async function transferNEAR(receiverWallet, amount) {

  try {
    await myKeyStore.setKey(connectionConfig.networkId, CREATOR_WALLET_ADDR, KeyPair.fromString(PRIVATE_KEY));

    let near = await connect(connectionConfig);
    let creatorAccount = await near.account(CREATOR_WALLET_ADDR);

    let rs = await creatorAccount.sendMoney(
      receiverWallet,
      utils.format.parseNearAmount(amount)
    )

    console.log(JSON.stringify({
      "status": "success",
      "message": `Transfer success: ${amount} NEAR to ${receiverWallet}`
    }));

  } catch (e) {
    console.log(JSON.stringify({
      "status": "error",
      "message": e.toString()
    }))
    // console.log("Error: " + e.toString());
  }

}//transferNEAR


transferNEAR(process.argv[2], process.argv[3] );

const envpath = '/home/cuong/projects/npoint/nodejs-scripts/.env';
require('dotenv').config({path:envpath});
const { utils } = require("near-api-js");
const nearAPI = require("near-api-js");
const { connect, keyStores, WalletConnection, KeyPair } = nearAPI;


const CREATOR_WALLET_ADDR = process.env.CREATOR_WALLET_ADDR;
const PRIVATE_KEY = process.env.PRIVATE_KEY;

const connectionConfig = {
  networkId: "testnet",
  nodeUrl: "https://rpc.testnet.near.org",
  walletUrl: "https://wallet.testnet.near.org",
  helperUrl: "https://helper.testnet.near.org",
  explorerUrl: "https://explorer.testnet.near.org",
};

async function createTopLevelAccount(newAccountId, amount) {

  // console.log(PRIVATE_KEY); return;
  try {

    // creates a public / private key pair using the provided private key
    // adds the keyPair you created to keyStore
    const myKeyStore = new keyStores.InMemoryKeyStore();
    await myKeyStore.setKey(connectionConfig.networkId, CREATOR_WALLET_ADDR, KeyPair.fromString(PRIVATE_KEY));
    connectionConfig.keyStore =  myKeyStore;
    let near = await connect(connectionConfig);
    let creatorAccount = await near.account(CREATOR_WALLET_ADDR);

    let newAccountKeyPair = KeyPair.fromRandom("ed25519");
    let publicKey = newAccountKeyPair.publicKey.toString();
    await myKeyStore.setKey(connectionConfig.networkId, newAccountId, newAccountKeyPair);

    let rs = await creatorAccount.functionCall({
      contractId: "testnet",
      methodName: "create_account",
      args: {
        new_account_id: newAccountId,
        new_public_key: publicKey,
      },
      gas: "300000000000000",
      attachedDeposit: utils.format.parseNearAmount(amount),
    });

    // console.log("Created new account : " , rs );
    console.log(JSON.stringify({
      "status": "success",
      "wallet": newAccountId,
      "privKey": "ed25519:" + newAccountKeyPair.secretKey,
      "message": "Create account success! "
    }))
  } catch (e) {
    console.log(e);
    console.log(JSON.stringify({
      "status": "error",
      "message": e.toString()
    }))
    // console.log("Error: " + e.toString());
  }

}


createTopLevelAccount(process.argv[2], "0.08");

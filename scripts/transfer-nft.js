const envpath = '/home/cuong/projects/npoint/nodejs-scripts/.env';
require("dotenv").config({path:envpath});
const { utils } = require("near-api-js");
const nearAPI = require("near-api-js");
const { connect, keyStores, WalletConnection, KeyPair } = nearAPI;

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



async function createAndTransferNFT(receiverWallet, imgurl, title, desc) {

  // console.log(process.argv); return;

  try {
    await myKeyStore.setKey( connectionConfig.networkId , CREATOR_WALLET_ADDR, KeyPair.fromString(PRIVATE_KEY));
    let near = await connect(connectionConfig);
    let creatorAccount = await near.account(CREATOR_WALLET_ADDR);

    let rs = await creatorAccount.functionCall({
      contractId: process.env.NFT_MARKET_ADDR,
      methodName: "nft_batch_mint",
      args: {
        owner_id: receiverWallet,
        metadata: {
          "media": imgurl,
          "title" : title, 
          "description" : desc,
          "extra":""
        },
        num_to_mint: 1,
         royalty_args: {
          split_between: {
            [process.env.CREATOR_WALLET_ADDR]: 10000
          },
          percentage: 500
        },
        token_ids_to_mint: null,
        split_owners: null
      },
      gas: "300000000000000",
      attachedDeposit: utils.format.parseNearAmount("0.1"),
    });

    console.log(JSON.stringify({
      "status": "success",
      "message": `Create NFT success: Transfer NFT "${title}" to ${receiverWallet}`
    }));

  } catch (e) {
    console.log(JSON.stringify({
      "status": "error",
      "message": e.toString()
    }))
    // console.log("Error: " + e.toString());
  }

}//transferNEAR

createAndTransferNFT(process.argv[2], process.argv[3] , process.argv[4] , process.argv[5]);

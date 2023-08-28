<?php

/**
 * Template Name: NFT Card page
 */

get_header();

?>
<?php
$cuser = wp_get_current_user();
?>
<div id="card-page" class="card-page">
    <h1 class="entry-title">My NFT cards</h1>
    <p>Send these cards to store to redeem for goods and services or <a href="/?page_id=27">trade on Mintbase Marketplace!</a> </p>
    <div id="card-list" class="row row-cols-1">

    </div> <!-- rows -->
</div><!-- store-wrap -->

<script>
    (($) => {
        $(document).ready(() => {
            console.log("card page ready");
            var contractId = "npoint.mintspace2.testnet";
            nSubContract.wallet.viewMethod({
                    contractId: contractId,
                    method: 'nft_tokens_for_owner',
                    args: {
                        "account_id": "<?= get_user_meta($cuser->ID, "near_wallet", true) ?>"
                    },
                })
                .then(rs => {
                    console.log(rs);
                    if(rs && rs.length>0) rs.reverse().map(ob => {
                        renderNFT(ob.token_id, ob.metadata.media, ob.metadata.title, ob.metadata.description);
                    });

                })
                .catch(err => console.log("Error: ", err))

            function renderNFT(nftid, img, title, desc) {
                var nfturl = "https://wallet.testnet.near.org/nft-detail/npoint.mintspace2.testnet/"+nftid;
                $("#card-list").append(`
<div class="card mb-3 bg-white border rounded-5 shadow">
  <div class="row g-0">
    <div class="col-md-5">
      <img
        src="${img}"
        title="${title}"
        alt="${title}"
        style="max-height: 200px;
    text-align: center;
    display: block;
    margin: 0 auto;
    padding: 15px;"
        class="img-fluid rounded-start"
      />
    </div>
    <div class="col-md-7">
      <div class="card-body">
        <h5 class="card-title">${title}</h5>
        <p class="card-text">${desc}</p>
        <a href="${nfturl}" target=_blank class="btn btn-outline-secondary px-5" data-nftid="${nftid}">Detail</a>

      </div>
    </div>
  </div>
</div>` );



            }
        }); //dom ready
    })(jQuery);
</script>

<?php
get_footer();

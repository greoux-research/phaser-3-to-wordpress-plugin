
var path,
    game,
    player,
    cursors;

jQuery(document).ready(function () {

    var w = jQuery("#pwp").width(),
        h = w * 3 / 4;

    jQuery("#pwp").height(h);

    path = jQuery("#pwp").attr("data-path");

    game = new Phaser.Game({
        width: w,
        height: h,
        backgroundColor: "#f9f9f9",
        scene: mainScene,
        physics: {
            default: "arcade",
            arcade: {
                gravity: { y: 150 },
                debug: false
            }
        },
        parent: "pwp"
    });

});

class mainScene {

    preload() {

        // This method is called once at the beginning
        // It will load all the assets, like sprites and sounds

        this.load.image("sky", path + "media/sky.png");
        this.load.spritesheet("sprite",
            path + "media/sprite.png",
            { frameWidth: 32, frameHeight: 48 }
        );

    }

    create() {

        // This method is called once, just after preload()
        // It will initialize our scene, like the positions of the sprites

        this.add.image(320, 240, "sky");

        player = this.physics.add.sprite(48, 48, "sprite");

        player.setBounce(0.2);
        player.setCollideWorldBounds(true);

        this.anims.create({
            key: "left",
            frames: this.anims.generateFrameNumbers("sprite", { start: 0, end: 3 }),
            frameRate: 10,
            repeat: -1
        });

        this.anims.create({
            key: "turn",
            frames: [{ key: "sprite", frame: 4 }],
            frameRate: 20
        });

        this.anims.create({
            key: "right",
            frames: this.anims.generateFrameNumbers("sprite", { start: 5, end: 8 }),
            frameRate: 10,
            repeat: -1
        });

        cursors = this.input.keyboard.createCursorKeys();

    }

    update() {

        // This method is called 60 times per second after create() 
        // It will handle all the game"s logic, like movements

        if (cursors.left.isDown) {
            player.setVelocityX(-150);
            player.anims.play("left", true);
        }
        else if (cursors.right.isDown) {
            player.setVelocityX(+150);
            player.anims.play("right", true);
        }
        else {
            player.setVelocityX(0);
            player.anims.play("turn");
        }

        if (cursors.up.isDown) {
            player.setVelocityY(-150);
        }

    }

}

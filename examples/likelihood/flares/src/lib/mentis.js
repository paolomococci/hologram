import { NeuralNetwork, CrossValidate } from 'brain.js'
import {
    INPUT_SIZE,
    HIDDEN_LAYERS,
    OUTPUT_SIZE,
    INPUT_RANGE,
    ACTIVATION,
    BINARY_THRESH,
    LEAKY_RELU_ALPHA,
    LEARNING_RATE,
    DECAY_RATE,
    ITERATIONS,
} from '../../env'

export const trainingAndSaveMentis = (trainingDataField) => {
    const neuralNetUp = new brain.recurrent.LSTMTimeStep({
        iterations: ITERATIONS,
        binaryThresh: BINARY_THRESH,
        inputSize: INPUT_SIZE,
        hiddenLayers: HIDDEN_LAYERS,
        activation: ACTIVATION,
        inputRange: INPUT_RANGE,
        outputSize: OUTPUT_SIZE,
        leakyReluAlpha: LEAKY_RELU_ALPHA,
        learningRate: LEARNING_RATE,
        decayRate: DECAY_RATE,
    })

    neuralNetUp.train(trainingDataField)
    const jsonNet = neuralNetUp.toJSON()
    console.log(jsonNet)

    return jsonNet
}

export const resumeMentis = (mentisJson) => {
    return JSON.parse(mentisJson)
}

export const makeEsteem = (mentis, coordinates) => {
    console.log('makeEsteem function')
    const neuralNetUp = new brain.recurrent.LSTMTimeStep()
    neuralNetUp.fromJSON(mentis)
    console.log(`Neural Network: ${neuralNetUp}`)
    console.log(`Coordinates: ${coordinates}`)
    const likely = neuralNetUp.forecast([coordinates])
    console.log(likely)

    return likely
}

export const estimateFromData = (trainingDataField) => {
    const neuralNetUp = new brain.recurrent.LSTMTimeStep({
        iterations: ITERATIONS,
        binaryThresh: BINARY_THRESH,
        inputSize: INPUT_SIZE,
        hiddenLayers: HIDDEN_LAYERS,
        activation: ACTIVATION,
        inputRange: INPUT_RANGE,
        outputSize: OUTPUT_SIZE,
        leakyReluAlpha: LEAKY_RELU_ALPHA,
        learningRate: LEARNING_RATE,
        decayRate: DECAY_RATE,
    })

    neuralNetUp.train(trainingDataField)

    const esteem = neuralNetUp.run(trainingDataField)

    return esteem
}

/** evaluate the probability that some coordinates will recur and returns an array of tuples sorted on the chance property */
export const makeEstimates = (formaMentis, tuples) => {
    let id = 0
    const chances = []
    tuples.forEach(tuple => {
        chances.push({
            'id': id,
            'chance': formaMentis.run(tuple)
        })
        id++
    })

    let compare = (first, second) => {
        if (first.chance < second.chance) {
            return -1
        } else if (first.chance > second.chance) {
            return 1
        } else {
            return 0
        }
    }
    chances.sort(compare)

    return chances
}